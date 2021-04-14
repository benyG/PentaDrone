<?php

namespace Selective\SameSiteCookie;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * SameSite Cookie Middleware.
 */
final class SameSiteCookieMiddleware implements MiddlewareInterface
{
    /**
     * @var string
     */
    private $sameSite;

    /**
     * @var bool
     */
    private $httpOnly;

    /**
     * @var bool
     */
    private $secure;

    /**
     * The constructor.
     *
     * @param SameSiteCookieConfiguration $configuration The configuration
     */
    public function __construct(SameSiteCookieConfiguration $configuration)
    {
        $this->sameSite = $configuration->sameSite;
        $this->httpOnly = $configuration->httpOnly;
        $this->secure = $configuration->secure;
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
        $response = $handler->handle($request);

        $sessionId = $request->getAttribute('session_id');
        $sessionName = $request->getAttribute('session_name');
        $params = $request->getAttribute('session_cookie_params');

        $cookieValues = [
            sprintf('%s=%s;', $sessionName, $sessionId),
            sprintf('path=%s;', $params['path']),
        ];

        if ($this->secure) {
            $cookieValues[] = 'Secure;';
        }

        if ($this->httpOnly) {
            $cookieValues[] = 'HttpOnly;';
        }

        if ($this->sameSite) {
            $cookieValues[] = sprintf('SameSite=%s;', $this->sameSite);
        }

        $response = $response->withHeader('Set-Cookie', implode(' ', $cookieValues));

        return $response;
    }
}
