<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

use PHPMaker2021\ITaudit_backoffice_v2\{UserProfile, Language, AdvancedSecurity, Timer, HttpErrorHandler};
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;
use DI\Container as Container;
use DI\ContainerBuilder;
use Selective\SameSiteCookie\SameSiteCookieConfiguration;
use Selective\SameSiteCookie\SameSiteCookieMiddleware;
use Selective\SameSiteCookie\SameSiteSessionMiddleware;
use Slim\Factory\AppFactory;
use Slim\Factory\ServerRequestCreatorFactory;
use Slim\Exception\HttpInternalServerErrorException;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;

// Relative path
$RELATIVE_PATH = "../";

// Require files
require_once "../vendor/autoload.php";
require_once "../src/constants.php";
require_once "../src/config.php";
require_once "../src/phpfn.php";
require_once "../src/userfn.php";

// Environment
$isProduction = IsProduction();
$isDebug = IsDebug();

// Warnings and notices as errors
if ($isDebug && Config("REPORT_ALL_ERRORS")) {
    error_reporting(E_ALL);
    set_error_handler(function ($severity, $message, $file, $line) {
        if (error_reporting() & $severity) {
            throw new \ErrorException($message, 0, $severity, $file, $line);
        }
    });
}

// Instantiate PHP-DI ContainerBuilder
$containerBuilder = new ContainerBuilder();

// Enable compilation
if ($isProduction && Config("COMPILE_CONTAINER") && !IsRemote(Config("UPLOAD_DEST_PATH"))) {
    $containerBuilder->enableCompilation(UploadPath(false) . "cache");
}

// Add definitions
$containerBuilder->addDefinitions("../src/definitions.php");

// Call Container Build event
if (function_exists(PROJECT_NAMESPACE . "Container_Build")) {
    Container_Build($containerBuilder);
}

// Build PHP-DI Container instance
$container = $containerBuilder->build();

// Instantiate the app
AppFactory::setContainer($container);
$app = AppFactory::create();
$callableResolver = $app->getCallableResolver();

// Display error details
$displayErrorDetails = $isDebug;
$logErrorToFile = Config("LOG_ERROR_TO_FILE");
$logErrors = $logErrorToFile || $isDebug;
$logErrorDetails = $logErrorToFile || $isDebug;

// Create request object from globals
$serverRequestCreator = ServerRequestCreatorFactory::create();
$Request = $serverRequestCreator->createServerRequestFromGlobals();

// Create error handler
$ResponseFactory = $app->getResponseFactory();
$errorHandler = new HttpErrorHandler($callableResolver, $ResponseFactory);

// Create shutdown handler
if (!$isDebug) {
    $shutdownHandler = new ShutdownHandler($Request, $errorHandler, $displayErrorDetails);
    register_shutdown_function($shutdownHandler);
}

// Add body parsing middleware
$app->addBodyParsingMiddleware();

// Add CORS middleware
$app->add(new CorsMiddleware());

// Add routing middleware (after CORS middleware so routing is performed first)
$app->addRoutingMiddleware();

// Set base path
$app->setBasePath(BasePath());

// Is API
$IsApi = true;

// Register routes (Add permission middleware)
(require_once "../src/apiroutes.php")($app);

// Add SameSite cookie/session middleware
if (UseSession($Request)) {
    $cookieConfiguration = new SameSiteCookieConfiguration();
    $cookieConfiguration->sameSite = Config("COOKIE_SAMESITE");
    $cookieConfiguration->httpOnly = Config("COOKIE_HTTP_ONLY");
    $cookieConfiguration->secure = Config("COOKIE_SECURE");
    $app->add(new SameSiteCookieMiddleware($cookieConfiguration));
    $app->add(new SameSiteSessionMiddleware($cookieConfiguration));
}

// Add error handling middleware
$errorMiddleware = $app->addErrorMiddleware($displayErrorDetails, $logErrors, $logErrorDetails);
$errorMiddleware->setDefaultErrorHandler($errorHandler);

// Run app
$app->run();
