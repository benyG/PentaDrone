<?php

namespace App\Http\Middleware;

use Closure;
use App;

class Localization
{ 
    public function handle($request, Closure $next) {
    if (session()->has('locale')) {
        App::setlocale(session()->get('locale'));
    }
    return $next($request);
}
}
