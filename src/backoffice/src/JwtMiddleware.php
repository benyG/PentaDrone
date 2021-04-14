<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Server\MiddlewareInterface;

/**
 * JWT middleware
 */
class JwtMiddleware implements MiddlewareInterface
{
    // Create JWT token
    public function create(Request $request, RequestHandler $handler): Response
    {
        global $Security, $ResponseFactory;

        // Get response
        $response = $handler->handle($request);

        // Authorize
        $Security = Container("security");
        $response = $ResponseFactory->createResponse();
        if ($Security->isLoggedIn()) {
            $jwt = $Security->createJwt();
            return $response->withJson($jwt); // Return JWT token
        } else {
            return $response->withStatus(401); // Not authorized
        }
    }

    // Validate JWT token
    public function process(Request $request, RequestHandler $handler): Response
    {
        global $UserProfile, $Security, $ResponseFactory;

        // Set up security from HTTP header or cookie
        $UserProfile = Container("profile");
        $Security = Container("security");
        $bearerToken = preg_replace('/^Bearer\s+/', "", $request->getHeaderLine(Config("JWT.AUTH_HEADER"))); // Get bearer token from HTTP header
        $token = $bearerToken ?: ReadCookie("JWT"); // Try cookie if no bearer token
        if ($token) {
            $jwt = DecodeJwt($token);
            if (is_array($jwt) && count($jwt) > 0) {
                if (array_key_exists("username", $jwt)) { // User name exists
                    $Security->loginUser(@$jwt["username"], @$jwt["userid"], @$jwt["parentuserid"], @$jwt["userlevelid"]); // Login user
                } else { // JWT error
                    $response = $ResponseFactory->createResponse();
                    $json = array_merge($jwt, ["success" => false, "version" => PRODUCT_VERSION]);
                    return $response->withJson($json);
                }
            }
        }

        // Process request
        return $handler->handle($request);
    }
}
