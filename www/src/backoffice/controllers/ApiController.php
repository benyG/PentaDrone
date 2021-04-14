<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

// API controller
class ApiController
{
    protected $container;

    // Constructor
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    // Login
    public function login(Request $request, Response $response, array $args): Response
    {
        global $Language, $UserProfile, $Security;
        $GLOBALS["Request"] = $request;
        if ($request->isGet()) {
            $username = $request->getQueryParam(Config("API_LOGIN_USERNAME"));
            $password = $request->getQueryParam(Config("API_LOGIN_PASSWORD"));
        } else {
            $username = $request->getParsedBodyParam(Config("API_LOGIN_USERNAME"));
            $password = $request->getParsedBodyParam(Config("API_LOGIN_PASSWORD"));
        }
        $UserProfile = Container("profile");
        $Security = Container("security");
        $Language = Container("language");
        $validPwd = $Security->validateUser($username, $password, false);
        if ($validPwd) {
            return $response;
        } else {
            return $response->withStatus(401); // Not authorized
        }
    }

    // Process route info and return json
    public function processRoute($pageName)
    {
        if ($pageName != "") {
            $pageClass = PROJECT_NAMESPACE . $pageName;
            if (class_exists($pageClass)) {
                $page = new $pageClass();
                return $page->run();
            }
        }
        return false;
    }

    // Process file request
    public function processFile()
    {
        $file = new FileViewer();
        return $file->getFile();
    }

    // Process file upload
    public function processFileUpload()
    {
        $upload = new HttpUpload();
        return $upload->getUploadedFiles();
    }

    // Process jQuery file upload
    public function processjQueryFileUpload()
    {
        $upload = new FileUploadHandler();
        return $upload->run();
    }

    // Process lookup
    public function processLookup($object)
    {
        $lookup = Container($object); // Get object created in API permission middleware
        return $lookup->lookup();
    }

    // Process session
    public function processSession()
    {
        $session = new SessionHandler();
        return $session->getSession();
    }

    // Process progress
    public function processProgress($token)
    {
        $data = GetCache($token); // Get import progress from file token
        if (is_array($data)) {
            WriteJson($data);
            return true;
        }
        return false;
    }

    // Process export chart
    public function processExportChart()
    {
        $exporter = new ChartExporter();
        return $exporter->export();
    }

    // Process permissions
    public function processPermissions($userLevel)
    {
        global $Security, $USER_LEVEL_TABLES;

        // Set up security
        $Security = Container("security");
        $Security->setupUserLevel(); // Get all User Level info
        $ar = $USER_LEVEL_TABLES;

        // Get permissions
        if (IsGet()) {
            // Check user level
            $userLevels = [-2]; // Default anonymous
            if ($Security->isLoggedIn()) {
                if ($Security->isSysAdmin() && is_numeric($userLevel) && !SameString($userLevel, "-1")) { // Get permissions for user level
                    if ($Security->userLevelIDExists($userLevel)) {
                        $userLevels = [$userLevel];
                    }
                } else {
                    $userLevel = $Security->CurrentUserLevelID;
                    $userLevels = $Security->UserLevelID;
                }
            }
            $userLevel = $userLevels[0];
            $privs = [];
            $cnt = count($ar);
            for ($i = 0; $i < $cnt; $i++) {
                $projectId = $ar[$i][4];
                $tableVar = $ar[$i][1];
                $tableName = $ar[$i][0];
                $allowed = $ar[$i][3];
                if ($allowed) {
                    $priv = 0;
                    foreach ($userLevels as $level) {
                        $priv |= $Security->getUserLevelPrivEx($projectId . $tableName, $level);
                    }
                    $privs[$tableVar] = $priv;
                }
            }
            $res = ["userlevel" => $userLevel, "permissions" => $privs];
            WriteJson($res);

        // Update permissions
        } elseif (IsPost() && $Security->isSysAdmin()) { // System admin only
            // Check user level
            if (!is_numeric($userLevel) || SameString($userLevel, "-1")) {
                return false;
            }

            // Update permissions for user level
            $privs = [];
            $privsOut = [];
            $cnt = count($ar);
            for ($i = 0; $i < $cnt; $i++) {
                $projectId = $ar[$i][4];
                $tableVar = $ar[$i][1];
                $tableName = $ar[$i][0];
                if (Post($tableVar) !== null) {
                    $priv = Post($tableVar);
                    if (is_numeric($priv)) {
                        $privs[$projectId . $tableName] = $priv;
                        $privsOut[$tableName] = $priv;
                    }
                }
            }
            if (method_exists($Security, "updatePermissions")) {
                $Security->updatePermissions($userLevel, $privs);
                $res = ["userlevel" => $userLevel, "permissions" => $privsOut, "success" => true];
                WriteJson($res);
            } else {
                return false;
            }
        }
        return true;
    }

    /**
     * Perform API call
     *
     * Routes:
     * 1. list/view/add/edit/delete/register
     *  - api/view/cars/1
     * 2. login
     *  - api/login
     * 3. file viewer
     *  - api/file/cars/Picture/1
     * 4. file upload
     *  - api/upload
     * 5. jQuery file upload
     *  - api/jupload
     * 6. session
     *  - api/session
     * 7. lookup (UpdateOption/ModalLookup/AutoSuggest/AutoFill)
     *  - api/lookup&ajax=(updateoption|modal|autosuggest|autofill)
     * 8. import progress
     *  - api/progress
     * 9. export chart
     *  - api/exprtchart
     * 10. permissions
     *  - api/permissions/-2
     * @return Response
     */
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        // Get route data
        $routeValues = $GLOBALS["RouteValues"];
        if (count($routeValues) > 0) {
            // Set up action
            $action = $routeValues[0] ?? Config("API_LIST_ACTION"); // Default action = list

            // Set up object
            $object = $routeValues[1] ?? Post(Config("API_OBJECT_NAME"));

            // Set up page name
            $pageName = "";
            $apiTableActions = [Config("API_LIST_ACTION"), Config("API_VIEW_ACTION"), Config("API_ADD_ACTION"), Config("API_EDIT_ACTION"), Config("API_DELETE_ACTION")];
            if (in_array($action, $apiTableActions)) {
                $pageName = Container($object)->getApiPageName($action);
            } elseif ($action == Config("API_REGISTER_ACTION")) { // Register
                $pageName = "Register";
            }

            // Set up response object
            $GLOBALS["Response"] = &$response; // Note: global $Response does not work

            // Handle custom actions first
            if (is_callable($GLOBALS["API_ACTIONS"][$action] ?? null)) { // Deprecated
                $func = $GLOBALS["API_ACTIONS"][$action];
                $func($request, $response);
            } elseif ($action == Config("API_UPLOAD_ACTION")) { // Upload file
                $this->processFileUpload();
            } elseif ($action == Config("API_JQUERY_UPLOAD_ACTION")) { // jQuery file upload
                $this->processjQueryFileUpload();
            } elseif ($action == Config("API_FILE_ACTION")) { // File viewer
                $this->processFile();
            } elseif ($action == Config("API_LOOKUP_ACTION")) { // Lookup
                $object = $request->getParam(Config("API_LOOKUP_PAGE")); // Get Lookup Page
                $this->processLookup($object);
            } elseif ($action == Config("API_SESSION_ACTION")) { // Session
                $this->processSession();
            } elseif ($action == Config("API_PROGRESS_ACTION")) { // Import progress
                $this->processProgress($request->getParam(Config("API_FILE_TOKEN_NAME")));
            } elseif ($action == Config("API_EXPORT_CHART_ACTION")) { // Export chart
                $this->processExportChart();
            } elseif ($action == Config("API_PERMISSIONS_ACTION")) { // Permissions
                $userLevel = count($routeValues) >= 2 ? $routeValues[1] : null;
                $this->processPermissions($userLevel);
            } else {
                $this->processRoute($pageName);
            }
        }
        return $response;
    }
}
