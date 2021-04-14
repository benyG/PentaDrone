<?php

namespace Selective\SameSiteCookie;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Native PHP Session Middleware.
 */
final class SameSiteSessionMiddleware implements MiddlewareInterface
{
    /**
     * @var bool
     */
    private $startSession;

    /**
     * The constructor.
     *
     * @param SameSiteCookieConfiguration $configuration The configuration
     */
    public function __construct(SameSiteCookieConfiguration $configuration)
    {
        $this->startSession = $configuration->startSession;
    }

    /**
     * Invoke middleware.
     *
     * @param ServerRequestInterface $request The request
     * @param RequestHandlerInterface $handler The handler
     *
     * @return ResponseInterface The response
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // Start session
        if ($this->startSession === true && session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $request = $request
            ->withAttribute('session_id', session_id())
            ->withAttribute('session_name', session_name())
            ->withAttribute('session_cookie_params', session_get_cookie_params());

        return $handler->handle($request);
    }
}
