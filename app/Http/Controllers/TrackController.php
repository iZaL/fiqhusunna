<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBookRequest;
use App\Jobs\PublishBook;
use Illuminate\Http\Request;

class TrackController extends Controller
{
    /**
     * @var BookRepository
     */
    private $bookRepository;

    /**
     * @param BookRepository $bookRepository
     */
    public function __construct()
    {
        $this->middleware('auth', ['on' => ['create', 'store']]);
    }

    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */
    public function index()
    {
    }

    public function create()
    {
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
    }
}
