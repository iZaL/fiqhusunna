<?php

namespace App\Http\Controllers;

use App\Src\Track\TrackRepository;
use Vinkla\Instagram\InstagramManager;

class HomeController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Home Controller
    |--------------------------------------------------------------------------
    |
    | This controller renders your application's "dashboard" for users that
    | are authenticated. Of course, you are free to change or remove the
    | controller as you wish. It is just here to get your app started!
    |
    */
    /**
     * @var InstagramManager
     */
    private $instagram;

    /**
     * Create a new controller instance.
     *
     * @param InstagramManager $instagram
     */
    public function __construct(InstagramManager $instagram)
    {
        $this->instagram = $instagram;
    }

    /**
     * Show the application dashboard to the user.
     *
     * @param TrackRepository $trackRepository
     * @return Response
     */
    public function index(TrackRepository $trackRepository)
    {
        $medias = $this->instagram->getUserMedia('1097866395');
        $instas = array_slice($medias->data, 0, 4);

        $tracks = $trackRepository->model->paginate(50)->all();

        return view('home', compact('instas','tracks'));
    }

}
