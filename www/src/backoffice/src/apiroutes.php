<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

use Slim\App;
use Slim\Routing\RouteCollectorProxy;

// Handle Routes
return function (App $app) {
    // API
    $app->any('/' . Config("API_LOGIN_ACTION"), ApiController::class . ':login')->add(JwtMiddleware::class . ':create')->setName('api/' . Config("API_LOGIN_ACTION")); // login
    $app->any('/' . Config("API_LIST_ACTION") . '[/{params:.*}]', ApiController::class)->add(ApiPermissionMiddleware::class)->add(new JwtMiddleware())->setName('api/' . Config("API_LIST_ACTION")); // list
    $app->any('/' . Config("API_VIEW_ACTION") . '[/{params:.*}]', ApiController::class)->add(ApiPermissionMiddleware::class)->add(new JwtMiddleware())->setName('api/' . Config("API_VIEW_ACTION")); // view
    $app->any('/' . Config("API_ADD_ACTION") . '[/{params:.*}]', ApiController::class)->add(ApiPermissionMiddleware::class)->add(new JwtMiddleware())->setName('api/' . Config("API_ADD_ACTION")); // add
    $app->any('/' . Config("API_EDIT_ACTION") . '[/{params:.*}]', ApiController::class)->add(ApiPermissionMiddleware::class)->add(new JwtMiddleware())->setName('api/' . Config("API_EDIT_ACTION")); // edit
    $app->any('/' . Config("API_DELETE_ACTION") . '[/{params:.*}]', ApiController::class)->add(ApiPermissionMiddleware::class)->add(new JwtMiddleware())->setName('api/' . Config("API_DELETE_ACTION")); // delete
    $app->any('/' . Config("API_FILE_ACTION") . '[/{params:.*}]', ApiController::class)->add(ApiPermissionMiddleware::class)->add(new JwtMiddleware())->setName('api/' . Config("API_FILE_ACTION")); // file
    $app->any('/' . Config("API_LOOKUP_ACTION") . '[/{params:.*}]', ApiController::class)->add(ApiPermissionMiddleware::class)->add(new JwtMiddleware())->setName('api/' . Config("API_LOOKUP_ACTION")); // lookup
    $app->any('/' . Config("API_UPLOAD_ACTION") . '[/{params:.*}]', ApiController::class)->add(ApiPermissionMiddleware::class)->add(new JwtMiddleware())->setName('api/' . Config("API_UPLOAD_ACTION")); // upload
    $app->any('/' . Config("API_JQUERY_UPLOAD_ACTION") . '[/{params:.*}]', ApiController::class)->add(ApiPermissionMiddleware::class)->setName('api/' . Config("API_JQUERY_UPLOAD_ACTION")); // jupload
    $app->any('/' . Config("API_SESSION_ACTION") . '[/{params:.*}]', ApiController::class)->add(ApiPermissionMiddleware::class)->setName('api/' . Config("API_SESSION_ACTION")); // session
    $app->any('/' . Config("API_PROGRESS_ACTION") . '[/{params:.*}]', ApiController::class)->add(ApiPermissionMiddleware::class)->setName('api/' . Config("API_PROGRESS_ACTION")); // session
    $app->any('/' . Config("API_EXPORT_CHART_ACTION") . '[/{params:.*}]', ApiController::class)->add(ApiPermissionMiddleware::class)->setName('api/' . Config("API_EXPORT_CHART_ACTION")); // chart
    $app->any('/' . Config("API_PERMISSIONS_ACTION") . '[/{params:.*}]', ApiController::class)->add(ApiPermissionMiddleware::class)->add(new JwtMiddleware())->setName('api/' . Config("API_PERMISSIONS_ACTION")); // permissions

    // User API actions
    if (function_exists(PROJECT_NAMESPACE . "Api_Action")) {
        Api_Action($app);
    }

    // Other API actions
    $app->any('/[{params:.*}]', ApiController::class)->add(ApiPermissionMiddleware::class)->setName('custom');
};
