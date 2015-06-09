<?php

namespace App\Http\Controllers;

use App\Src\Track\TrackRepository;
use Vinkla\Instagram\InstagramManager;

class HomeController extends Controller
{

    /**
     * Show the application dashboard to the user.
     *
     * @param InstagramManager $instagram
     * @param TrackRepository $trackRepository
     * @return Response
     */
    public function index(InstagramManager $instagram, TrackRepository $trackRepository)
    {
        $medias = $instagram->getUserMedia('1097866395');
        $instas = array_slice($medias->data, 0, 4);

        $tracks = $trackRepository->model->paginate(50)->all();

        return view('home', compact('instas', 'tracks'));
    }

}
