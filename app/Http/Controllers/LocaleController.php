<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class LocaleController extends Controller
{
    /**
     * @param $lang
     * @return mixed
     */
    public function changeLocale($lang)
    {
        Session::put('locale', $lang);

        return Redirect::back();
    }

}