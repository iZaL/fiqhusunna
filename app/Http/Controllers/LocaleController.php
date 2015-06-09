<?php

namespace App\Http\Controllers;

use Redirect;
use Session;

class LocaleController extends Controller
{

    public function setLocale($locale)
    {
        Session::put('locale', $locale);

        return Redirect::back();
    }

}