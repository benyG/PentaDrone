<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

use Slim\Routing\RouteContext;
use Psr\Http\Message\ResponseInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpException;
use Slim\Exception\HttpForbiddenException;
use Slim\Exception\HttpMethodNotAllowedException;
use Slim\Exception\HttpNotFoundException;
use Slim\Exception\HttpNotImplementedException;
use Slim\Exception\HttpUnauthorizedException;
use Slim\Handlers\ErrorHandler;
use Exception;
use Throwable;

class HttpErrorHandler extends ErrorHandler
{
    // Log error
    protected function logError(string $error): void
    {
        Log($error);
    }

    // Respond
    protected function respond(): ResponseInterface
    {
        global $Request, $Language, $Breadcrumb;
        $exception = $this->exception;
        $statusCode = $exception->getCode();
        $Language = Container("language");
        $type = $Language->phrase("Error");
        $description = $Language->phrase("ServerError");
        $error = [
            "statusCode" => 0,
            "error" => [
                "class" => "text-danger",
                "type" => $type,
                "description" => $description,
            ],
        ];
        if ($exception instanceof HttpException) {
            $description = $exception->getMessage();
            if (
                $exception instanceof HttpNotFoundException || // 404
                $exception instanceof HttpMethodNotAllowedException || // 405
                $exception instanceof HttpUnauthorizedException || // 401
                $exception instanceof HttpForbiddenException || // 403
                $exception instanceof HttpBadRequestException || // 400
                $exception instanceof HttpInternalServerErrorException || // 500
                $exception instanceof HttpNotImplementedException // 501
            ) {
                $type = $Language->phrase($statusCode);
                $description = $Language->phrase($statusCode . "Desc");
                $error = [
                    "statusCode" => $statusCode,
                    "error" => [
                        "class" => ($exception instanceof HttpInternalServerErrorException) ? "text-danger" : "text-warning",
                        "type" => $type,
                        "description" => $description,
                    ],
                ];
            }
        }
        if (!($exception instanceof HttpException) && ($exception instanceof Exception || $exception instanceof Throwable)) {
            if ($this->displayErrorDetails) {
                if ($exception instanceof \ErrorException) {
                    $severity = $exception->getSeverity();
                    if ($severity === E_WARNING) {
                        $error["error"]["class"] = "text-warning";
                        $error["error"]["type"] = $Language->phrase("Warning");
                    } elseif ($severity === E_NOTICE) {
                        $error["error"]["class"] = "text-warning";
                        $error["error"]["type"] = $Language->phrase("Notice");
                    }
                }
                $description = $exception->getFile() . "(" . $exception->getLine() . "): " . $exception->getMessage();
                $error["error"]["description"] = $description;
            }
        }

        // Create response object
        $response = $this->responseFactory->createResponse();

        // Show error as JSON
        $routeName = RouteName();
        if (
            IsApi() || // API request
            $routeName === null || // No route context
            preg_match('/(\-preview(\-2)?|^error)$/', $routeName) || // Preview page or Error page (Avoid infinite redirect)
            $Request->getParam("modal") == "1" // Modal request
        ) {
            return $response->withJson(ConvertToUtf8($error), @$error["statusCode"] ?: null);
        }

        // Set flash message for next request
        Container("flash")->addMessage("error", $error);

        // Redirect
        return $response->withStatus(302)->withHeader("Location", GetUrl("error"));
    }
}
