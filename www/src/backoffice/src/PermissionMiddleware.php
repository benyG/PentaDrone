<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

use Slim\Routing\RouteContext;
use Slim\Exception\HttpBadRequestException;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Nyholm\Psr7\Factory\Psr17Factory;

/**
 * Permission middleware
 */
class PermissionMiddleware
{
    // Invoke
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        global $Language, $UserProfile, $Security, $ResponseFactory;

        // Non-API call
        $GLOBALS["IsApi"] = false;

        // Set up request
        $GLOBALS["Request"] = $request;
        $response = $ResponseFactory->createResponse();
        $routeContext = RouteContext::fromRequest($request);
        $route = $routeContext->getRoute();
        //$basePath = $routeContext->getBasePath();
        //$routeParser = $routeContext->getRouteParser();
        $pageAction = $route->getName();
        $ar = explode("-", $pageAction);
        $currentPageName = @$ar[0]; // Get current page name
        $GLOBALS["RouteValues"] = [$currentPageName];
        if (count($ar) > 2) {
            list(, $table, $pageAction) = $ar;
        }

        // Set up Page ID
        if (!defined(PROJECT_NAMESPACE . "PAGE_ID")) {
            define(PROJECT_NAMESPACE . "PAGE_ID", $pageAction);
        }

        // Set up language
        $Language = Container("language");

        // Load Security
        $UserProfile = Container("profile");
        $Security = Container("security");

        // Auto login
        if (!$Security->isLoggedIn()) {
            $Security->autoLogin();
        }

        // Validate security
        if (isset($table) && $table != "") { // Table level
            $GLOBALS["Table"] = Container($table); // Set up current table
            $Security->loadTablePermissions($table);
            if (
                $pageAction == Config("VIEW_ACTION") && !$Security->canView() ||
                in_array($pageAction, [Config("EDIT_ACTION"), Config("UPDATE_ACTION")]) && !$Security->canEdit() ||
                $pageAction == Config("ADD_ACTION") && !$Security->canAdd() ||
                $pageAction == Config("DELETE_ACTION") && !$Security->canDelete() ||
                $pageAction == Config("SEARCH_ACTION") && !$Security->canSearch()
            ) {
                $Security->saveLastUrl();
                $_SESSION[SESSION_FAILURE_MESSAGE] = DeniedMessage(); // Set no permission
                if ($Security->canList()) { // Back to list
                    $pageAction = Config("LIST_ACTION");
                    $routeName = $GLOBALS["Table"]->getListUrl();
                    return $this->getRedirectResponse($request, $response, $routeName . "-" . $table . "-" . $pageAction);
                } else {
                    return $this->getRedirectResponse($request, $response);
                }
            } elseif (
                $pageAction == Config("LIST_ACTION") && !$Security->canList() || // List Permission
                in_array($pageAction, [Config("CUSTOM_REPORT_ACTION"), Config("SUMMARY_REPORT_ACTION"), Config("CROSSTAB_REPORT_ACTION"), Config("DASHBOARD_REPORT_ACTION")]) && !$Security->canReport()
            ) { // No permission
                $Security->saveLastUrl();
                $_SESSION[SESSION_FAILURE_MESSAGE] = DeniedMessage(); // Set no permission
                return $this->getRedirectResponse($request, $response);
            }
        } else { // Others
            if ($pageAction == "changepassword") { // Change password
                if (!IsPasswordReset() && !IsPasswordExpired()) {
                    if (!$Security->isLoggedIn() || $Security->isSysAdmin()) {
                        return $this->getRedirectResponse($request, $response);
                    }
                }
            } elseif ($pageAction == "personaldata") { // Personal data
                if (!$Security->isLoggedIn() || $Security->isSysAdmin()) {
                    $_SESSION[SESSION_FAILURE_MESSAGE] = DeniedMessage(); // Set no permission
                    return $this->getRedirectResponse($request, $response);
                }
            } elseif ($pageAction == "userpriv") { // User priv
                $table = "";
                $pageAction = Config("LIST_ACTION");
                $routeName = Container($table)->getListUrl();
                $Security->loadTablePermissions($table);
                if (!$Security->isLoggedIn() || !$Security->isAdmin()) {
                    $_SESSION[SESSION_FAILURE_MESSAGE] = DeniedMessage(); // Set no permission
                    return $this->getRedirectResponse($request, $response, $routeName . "-" . $table . "-" . $pageAction);
                }
            }
        }

        // Validate CSRF
        if (Config("CHECK_TOKEN") && IsPost() && !ValidateCsrf()) {
            throw new HttpBadRequestException($request, $Language->phrase("InvalidPostRequest"));
        }

        // Handle request
        return $handler->handle($request);
    }

    // Get response for redirection
    public function getRedirectResponse(Request $request, Response $response, string $url = "login")
    {
        $isModal = $request->getQueryParam("modal") == "1";
        if ($isModal) {
            if ($url == "login" && Config("USE_MODAL_LOGIN")) { // Redirect to login
                return $response->withHeader("Location", UrlFor($url))->withStatus(302);
            } else {
                return $response->withJson(["url" => UrlFor($url)]);
            }
        } else {
            return $response->withHeader("Location", UrlFor($url))->withStatus(302);
        }
    }
}
