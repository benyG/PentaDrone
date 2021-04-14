<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Routing\RouteContext;

/**
 * CORS middleware
 */
final class CorsMiddleware implements MiddlewareInterface
{
    /**
     * Invoke middleware
     *
     * @param ServerRequestInterface $request The request
     * @param RequestHandlerInterface $handler The handler
     *
     * @return ResponseInterface The response
     */
    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        $routeContext = RouteContext::fromRequest($request);
        $routingResults = $routeContext->getRoutingResults();
        $methods = $routingResults->getAllowedMethods();
        $requestHeaders = $request->getHeaderLine("Access-Control-Request-Headers");
        $response = $handler->handle($request);
        $response = $response
            ->withHeader("Access-Control-Allow-Origin", "*" ?: "*")
            ->withHeader("Access-Control-Allow-Methods", implode(", ", array_unique($methods)))
            ->withHeader("Access-Control-Allow-Headers", $requestHeaders ?: "*, X-Requested-With, Content-Type, Accept, Origin, X-Authorization" ?: "*");

        // Optional: Allow Ajax CORS requests with Authorization header
        $response = $response->withHeader("Access-Control-Allow-Credentials", "true");
        return $response;
    }
}
