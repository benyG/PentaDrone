<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpNotFoundException;

/**
 * Controller base class
 */
class ControllerBase
{
    protected $container;

    // Constructor
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    // Run page
    protected function runPage(Request $request, Response $response, array $args, string $pageName, bool $useLayout = true): Response
    {
        global $RouteValues;

        // Route values
        // Note: $RouteValues[0] set up in PermissionMiddleWare
        $RouteValues = array_merge($RouteValues, $args, array_values($args));

        // Generate new CSRF token
        GenerateCsrf();

        // Create page
        $pageClass = PROJECT_NAMESPACE . $pageName;
        if (class_exists($pageClass)) {
            // Set up response object
            $GLOBALS["Response"] = &$response; // Note: global $Response does not work

            // Create page object
            $page = new $pageClass();
            $GLOBALS["Page"] = &$page;

            // Write header
            $cache = ($page->PageID != "preview") ? Config("CACHE") : false; // No cache for preview
            WriteHeader($cache);

            // Run the page
            $page->run();

            // Render page if not terminated
            if (!$page->isTerminated()) {
                $view = $this->container->get("view");
                $template = $pageName . ".php";
                if ($useLayout) {
                    $view->setLayout("layout.php");
                }

                // Render view with $GLOBALS
                $page->RenderingView = true;
                $responseView = $view->render($response, $template, $GLOBALS);
                $page->RenderingView = false;

                // Terminate page and clean up
                if (!$page->isTerminated()) {
                    $response = $responseView;
                    $page->terminate();
                }
            }
            return $response;
        }

        // Page not found
        throw new HttpNotFoundException($request);
    }
}
