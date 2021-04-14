<?php

namespace Selective\SameSiteCookie;

/**
 * SameSite Cookie Configuration.
 */
final class SameSiteCookieConfiguration
{
    /**
     * @var bool Start the session
     */
    public $startSession = true;

    /**
     * @var string Send cookie only via a href link. Values: 'Lax' or 'Strict'.
     */
    public $sameSite = 'Lax';

    /**
     * @var bool Prevents cookies from being read by scripts. Should be enabled.
     */
    public $httpOnly = true;

    /**
     * @var bool Provide cookies only via ssl. Should be enabled in production.
     */
    public $secure = true;
}
