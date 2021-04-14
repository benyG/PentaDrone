# selective/samesite-cookie

Secure your site with SameSite cookies :cookie:

[![Latest Version on Packagist](https://img.shields.io/github/release/selective-php/samesite-cookie.svg?style=flat-square)](https://packagist.org/packages/selective/samesite-cookie)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/selective-php/samesite-cookie/master.svg?style=flat-square)](https://travis-ci.org/selective-php/samesite-cookie)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/selective-php/samesite-cookie.svg?style=flat-square)](https://scrutinizer-ci.com/g/selective-php/samesite-cookie/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/quality/g/selective-php/samesite-cookie.svg?style=flat-square)](https://scrutinizer-ci.com/g/selective-php/samesite-cookie/?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/selective/samesite-cookie.svg?style=flat-square)](https://packagist.org/packages/selective/samesite-cookie/stats)

## Requirements

* PHP 7.1+

## Installation

```
composer require selective/samesite-cookie
```

## SameSite cookies

Same-site cookies ("First-Party-Only" or "First-Party") allow servers to mitigate 
the risk of CSRF and information leakage attacks by asserting that a particular 
cookie should only be sent with requests initiated from the same registrable domain.

**Warning:** SameSite cookies doesn't work at all for old Browsers and 
also not for some Mobil Browsers e.g. IE 10, Blackberry, Opera Mini, 
IE Mobile, UC Browser for Android.

Further details can be found here:

* [SameSite cookies explained](https://web.dev/samesite-cookies-explained)
* [CSRF is (really) dead](https://scotthelme.co.uk/csrf-is-really-dead/)
* [PHP setcookie “SameSite=Strict”?](https://stackoverflow.com/questions/39750906/php-setcookie-samesite-strict)
* [How to Set a cookie attribute Samesite value in PHP ?](https://www.tutorialshore.com/how-to-set-a-cookie-attribute-samesite-value-in-php/)
* [Can I use SameSite?](https://caniuse.com/#feat=same-site-cookie-attribute)

## Slim 4 integration

Slim 4 uses a LIFO (last in, first out) middleware stack,
so we have to add the middleware in reverse order:

```php
<?php

use Selective\SameSiteCookie\SameSiteCookieConfiguration;
use Selective\SameSiteCookie\SameSiteCookieMiddleware;
use Selective\SameSiteCookie\SameSiteSessionMiddleware;
use Slim\Factory\AppFactory;

$app = AppFactory::create();

// ...

$configuration = new SameSiteCookieConfiguration();

// Register the samesite cookie middleware
$app->add(new SameSiteCookieMiddleware($configuration));

// Start the native PHP session handler and fetch the session attributes
$app->add(new SameSiteSessionMiddleware($configuration));

// ...

$app->run();
```

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
