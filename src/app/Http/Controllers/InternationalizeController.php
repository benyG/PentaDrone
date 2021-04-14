<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use App;

class InternationalizeController extends Controller
{
    public function language($locale) {
        App::setlocale($locale);
        Session::put('locale', $locale);
        return back();
    }
}
