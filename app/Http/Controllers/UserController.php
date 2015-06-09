<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get Authenticated Users Profile
     * @return \Illuminate\View\View
     */
    public function profile()
    {
        $user = Auth::user();

        // get the books uploaded by this user
        $books = $user->books()->with(['meta'])->get();

        return view('modules.user.profile', compact('user', 'books'));

    }
}
