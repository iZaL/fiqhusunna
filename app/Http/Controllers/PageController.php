<?php

namespace App\Http\Controllers;

use App\Jobs\SendContactMail;
use Illuminate\Http\Request;

class PageController extends Controller
{

    public function getAbout()
    {
        return view('pages.about');
    }


    public function getContact()
    {
        return view('pages.contact');
    }

    /**
     * Post Contact Form
     * @param Request $request
     */
    public function postContact(Request $request)
    {
        $this->validate($request, [
            'name'  => 'required',
            'email' => 'required|email',
            'body'  => 'required'
        ]);

        $job = (new SendContactMail($request));
        $this->dispatch($job);

        return redirect('home')->with('success', trans('word.mail_sent'));
    }

}
