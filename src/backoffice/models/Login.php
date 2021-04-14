<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class Login
{
    use MessagesTrait;

    // Page ID
    public $PageID = "login";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "Login";

    // Rendering View
    public $RenderingView = false;

    // Page headings
    public $Heading = "";
    public $Subheading = "";
    public $PageHeader;
    public $PageFooter;

    // Page terminated
    private $terminated = false;

    // Page heading
    public function pageHeading()
    {
        global $Language;
        if ($this->Heading != "") {
            return $this->Heading;
        }
        if (method_exists($this, "tableCaption")) {
            return $this->tableCaption();
        }
        return "";
    }

    // Page subheading
    public function pageSubheading()
    {
        global $Language;
        if ($this->Subheading != "") {
            return $this->Subheading;
        }
        return "";
    }

    // Page name
    public function pageName()
    {
        return CurrentPageName();
    }

    // Page URL
    public function pageUrl()
    {
        $url = ScriptName() . "?";
        return $url;
    }

    // Show Page Header
    public function showPageHeader()
    {
        $header = $this->PageHeader;
        $this->pageDataRendering($header);
        if ($header != "") { // Header exists, display
            echo '<p id="ew-page-header">' . $header . '</p>';
        }
    }

    // Show Page Footer
    public function showPageFooter()
    {
        $footer = $this->PageFooter;
        $this->pageDataRendered($footer);
        if ($footer != "") { // Footer exists, display
            echo '<p id="ew-page-footer">' . $footer . '</p>';
        }
    }

    // Validate page request
    protected function isPageRequest()
    {
        return true;
    }

    // Constructor
    public function __construct()
    {
        global $Language, $DashboardReport, $DebugTimer;

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("language");

        // Start timer
        $DebugTimer = Container("timer");

        // Debug message
        LoadDebugMessage();

        // Open connection
        $GLOBALS["Conn"] = $GLOBALS["Conn"] ?? GetConnection();
    }

    // Get content from stream
    public function getContents($stream = null): string
    {
        global $Response;
        return is_object($Response) ? $Response->getBody() : ob_get_clean();
    }

    // Is lookup
    public function isLookup()
    {
        return SameText(Route(0), Config("API_LOOKUP_ACTION"));
    }

    // Is AutoFill
    public function isAutoFill()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autofill");
    }

    // Is AutoSuggest
    public function isAutoSuggest()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autosuggest");
    }

    // Is modal lookup
    public function isModalLookup()
    {
        return $this->isLookup() && SameText(Post("ajax"), "modal");
    }

    // Is terminated
    public function isTerminated()
    {
        return $this->terminated;
    }

    /**
     * Terminate page
     *
     * @param string $url URL for direction
     * @return void
     */
    public function terminate($url = "")
    {
        if ($this->terminated) {
            return;
        }
        global $ExportFileName, $TempImages, $DashboardReport, $Response;

        // Page is terminated
        $this->terminated = true;

         // Page Unload event
        if (method_exists($this, "pageUnload")) {
            $this->pageUnload();
        }

        // Global Page Unloaded event (in userfn*.php)
        Page_Unloaded();

        // Export
        if (!IsApi() && method_exists($this, "pageRedirecting")) {
            $this->pageRedirecting($url);
        }

        // Close connection
        CloseConnections();

        // Return for API
        if (IsApi()) {
            $res = $url === true;
            if (!$res) { // Show error
                WriteJson(array_merge(["success" => false], $this->getMessages()));
            }
            return;
        } else { // Check if response is JSON
            if (StartsString("application/json", $Response->getHeaderLine("Content-type")) && $Response->getBody()->getSize()) { // With JSON response
                $this->clearMessages();
                return;
            }
        }

        // Go to URL if specified
        if ($url != "") {
            if (!Config("DEBUG") && ob_get_length()) {
                ob_end_clean();
            }

            // Handle modal response
            if ($this->IsModal) { // Show as modal
                $row = ["url" => $url];
                WriteJson($row);
            } else {
                SaveDebugMessage();
                Redirect(GetUrl($url));
            }
        }
        return; // Return to controller
    }

    // Properties
    public $Username;
    public $Password;
    public $LoginType;
    public $IsModal = false;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm,
            $Breadcrumb, $SkipHeaderFooter;
        $this->OffsetColumnClass = ""; // Override user table

        // Create Username/Password field object (used by validation only)
        $this->Username = new DbField("login", "login", "username", "username", "username", "", 202, 255, 0, false, "", false, false, false);
        $this->Username->EditAttrs->appendClass("form-control ew-control");
        $this->Password = new DbField("login", "login", "password", "password", "password", "", 202, 255, 0, false, "", false, false, false);
        $this->Password->EditAttrs->appendClass("form-control ew-control");
        if (Config("ENCRYPTED_PASSWORD")) {
            $this->Password->Raw = true;
        }
        $this->LoginType = new DbField("login", "login", "type", "logintype", "logintype", "", 202, 255, 0, false, "", false, false, false);

        // Is modal
        $this->IsModal = Param("modal") == "1";

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $Breadcrumb = new Breadcrumb("index");
        $Breadcrumb->add("login", "LoginPage", CurrentUrl(), "", "", true);
        $this->Heading = $Language->phrase("LoginPage");
        $this->Username->setFormValue(""); // Initialize
        $this->Password->setFormValue("");
        $this->LoginType->setFormValue("");
        $lastUrl = $Security->lastUrl(); // Get last URL
        if ($lastUrl == "") {
            $lastUrl = "index";
        }

        // Show messages
        $flash = Container("flash");
        if ($failure = $flash->getFirstMessage("failure")) {
            $this->setFailureMessage($failure);
        }
        if ($success = $flash->getFirstMessage("success")) {
            $this->setSuccessMessage($success);
        }
        if ($warning = $flash->getFirstMessage("warning")) {
            $this->setWarningMessage(warning);
        }

        // Login
        if (IsLoggingIn()) { // After changing password
            $this->Username->setFormValue(Session(SESSION_USER_PROFILE_USER_NAME));
            $this->Password->setFormValue(Session(SESSION_USER_PROFILE_PASSWORD));
            $this->LoginType->setFormValue(Session(SESSION_USER_PROFILE_LOGIN_TYPE));
            $validPwd = $Security->validateUser($this->Username->CurrentValue, $this->Password->CurrentValue, false);
            if ($validPwd) {
                $_SESSION[SESSION_USER_PROFILE_USER_NAME] = "";
                $_SESSION[SESSION_USER_PROFILE_PASSWORD] = "";
                $_SESSION[SESSION_USER_PROFILE_LOGIN_TYPE] = "";
            }
        } elseif (Get("provider")) { // OAuth provider
            $provider = ucfirst(strtolower(trim(Get("provider")))); // e.g. Google, Facebook
            $validate = $Security->validateUser($this->Username->CurrentValue, $this->Password->CurrentValue, false, $provider); // Authenticate by provider
            $validPwd = $validate;
            if ($validate) {
                $this->Username->setFormValue($UserProfile->get("email"));
                if (Config("DEBUG") && !$Security->isLoggedIn()) {
                    $validPwd = false;
                    $this->setFailureMessage(str_replace("%u", $this->Username->CurrentValue, $Language->phrase("UserNotFound"))); // Show debug message
                }
            } else {
                $this->setFailureMessage(str_replace("%p", $provider, $Language->phrase("LoginFailed")));
            }
        } else { // Normal login
            if (!$Security->isLoggedIn()) {
                $Security->autoLogin();
            }
            $Security->loadUserLevel(); // Load user level
            if ($Security->isLoggedIn()) {
                if ($this->getFailureMessage() != "") { // Show error
                    $error = [
                        "statusCode" => 0,
                        "error" => [
                            "class" => "text-warning",
                            "type" => "",
                            "description" => $this->getFailureMessage(),
                        ],
                    ];
                    Container("flash")->addMessage("error", $error);
                    $lastUrl = "error";
                    $this->clearFailureMessage();
                }
                $this->terminate($lastUrl); // Redirect to error page
                return;
            }
            $validate = false;
            if (Post($this->Username->FieldVar) !== null) {
                $this->Username->setFormValue(Post($this->Username->FieldVar));
                $this->Password->setFormValue(Post($this->Password->FieldVar));
                $this->LoginType->setFormValue(strtolower(Post($this->LoginType->FieldVar)));
                $validate = $this->validateForm();
            } elseif (Config("ALLOW_LOGIN_BY_URL") && Get($this->Username->FieldVar) !== null) {
                $this->Username->setQueryStringValue(Get($this->Username->FieldVar));
                $this->Password->setQueryStringValue(Get($this->Password->FieldVar));
                $this->LoginType->setQueryStringValue(strtolower(Get($this->LoginType->FieldVar)));
                $validate = $this->validateForm();
            } else { // Restore settings
                if (ReadCookie("Checksum") == strval(crc32(md5(Config("RANDOM_KEY"))))) {
                    $this->Username->setFormValue(Decrypt(ReadCookie("Username")));
                }
                if (ReadCookie("AutoLogin") == "autologin") {
                    $this->LoginType->setFormValue("a");
                } else { // Restore settings
                    $this->LoginType->setFormValue("");
                }
            }
            if (!EmptyValue($this->Username->CurrentValue)) {
                $_SESSION[SESSION_USER_LOGIN_TYPE] = $this->LoginType->CurrentValue; // Save user login type
                $_SESSION[SESSION_USER_PROFILE_USER_NAME] = $this->Username->CurrentValue; // Save login user name
                $_SESSION[SESSION_USER_PROFILE_LOGIN_TYPE] = $this->LoginType->CurrentValue; // Save login type
            }
            $validPwd = false;
            if ($validate) {
                // Call Logging In event
                $validate = $this->userLoggingIn($this->Username->CurrentValue, $this->Password->CurrentValue);
                if ($validate) {
                    $validPwd = $Security->validateUser($this->Username->CurrentValue, $this->Password->CurrentValue, false); // Manual login
                    if (!$validPwd) {
                        $this->Username->setFormValue(""); // Clear login name
                        $this->Username->addErrorMessage($Language->phrase("InvalidUidPwd")); // Invalid user name or password
                        $this->Password->addErrorMessage($Language->phrase("InvalidUidPwd")); // Invalid user name or password
                    }
                } else {
                    if ($this->getFailureMessage() == "") {
                        $this->setFailureMessage($Language->phrase("LoginCancelled")); // Login cancelled
                    }
                }
            }
        }

        // After login
        if ($validPwd) {
            // Write cookies
            if ($this->LoginType->CurrentValue == "a") { // Auto login
                WriteCookie("AutoLogin", "autologin"); // Set autologin cookie
                WriteCookie("Username", Encrypt($this->Username->CurrentValue)); // Set user name cookie
                WriteCookie("Password", Encrypt($this->Password->CurrentValue)); // Set password cookie
                WriteCookie('Checksum', crc32(md5(Config("RANDOM_KEY"))));
            } else {
                WriteCookie("AutoLogin", ""); // Clear auto login cookie
            }

            // Call loggedin event
            $this->userLoggedIn($this->Username->CurrentValue);
            $this->terminate($lastUrl); // Return to last accessed URL
            return;
        } elseif (!EmptyValue($this->Username->CurrentValue) && !EmptyValue($this->Password->CurrentValue)) {
            // Call user login error event
            $this->userLoginError($this->Username->CurrentValue, $this->Password->CurrentValue);
        }

        // Set up error message
        if (EmptyValue($this->Username->ErrorMessage)) {
            $this->Username->ErrorMessage = $Language->phrase("EnterUserName");
        }
        if (EmptyValue($this->Password->ErrorMessage)) {
            $this->Password->ErrorMessage = $Language->phrase("EnterPassword");
        }

        // Set LoginStatus / Page_Rendering / Page_Render
        if (!IsApi() && !$this->isTerminated()) {
            // Setup login status
            SetupLoginStatus();

            // Pass login status to client side
            SetClientVar("login", LoginStatus());

            // Global Page Rendering event (in userfn*.php)
            Page_Rendering();

            // Page Rendering event
            if (method_exists($this, "pageRender")) {
                $this->pageRender();
            }
        }
    }

    // Validate form
    protected function validateForm()
    {
        global $Language;

        // Check if validation required
        if (!Config("SERVER_VALIDATE")) {
            return true;
        }
        $validateForm = true;
        if (EmptyValue($this->Username->CurrentValue)) {
            $this->Username->addErrorMessage($Language->phrase("EnterUserName"));
            $validateForm = false;
        }
        if (EmptyValue($this->Password->CurrentValue)) {
            $this->Password->addErrorMessage($Language->phrase("EnterPassword"));
            $validateForm = false;
        }

        // Call Form Custom Validate event
        $formCustomError = "";
        $validateForm = $validateForm && $this->formCustomValidate($formCustomError);
        if ($formCustomError != "") {
            $this->setFailureMessage($formCustomError);
        }
        return $validateForm;
    }

    // Page Load event
    public function pageLoad()
    {
        //Log("Page Load");
    }

    // Page Unload event
    public function pageUnload()
    {
        //Log("Page Unload");
    }

    // Page Redirecting event
    public function pageRedirecting(&$url)
    {
        // Example:
        //$url = "your URL";
    }

    // Message Showing event
    // $type = ''|'success'|'failure'
    public function messageShowing(&$msg, $type)
    {
        // Example:
        //if ($type == 'success') $msg = "your success message";
    }

    // Page Render event
    public function pageRender()
    {
        //Log("Page Render");
    }

    // Page Data Rendering event
    public function pageDataRendering(&$header)
    {
        // Example:
        //$header = "your header";
    }

    // Page Data Rendered event
    public function pageDataRendered(&$footer)
    {
        // Example:
        //$footer = "your footer";
    }

    // User Logging In event
    public function userLoggingIn($usr, &$pwd)
    {
        // Enter your code here
        // To cancel, set return value to false
        return true;
    }

    // User Logged In event
    public function userLoggedIn($usr)
    {
        //Log("User Logged In");
    }

    // User Login Error event
    public function userLoginError($usr, $pwd)
    {
        //Log("User Login Error");
    }

    // Form Custom Validate event
    public function formCustomValidate(&$customError)
    {
        // Return error message in CustomError
        return true;
    }
}
