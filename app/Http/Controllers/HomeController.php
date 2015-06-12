<?php

namespace App\Http\Controllers;

use App\Src\Album\AlbumRepository;
use App\Src\Track\TrackRepository;
use Vinkla\Instagram\InstagramManager;

class HomeController extends Controller
{

    /**
     * Show the application dashboard to the user.
     *
     * @param InstagramManager $instagram
     * @param TrackRepository $trackRepository
     * @param AlbumRepository $albumRepository
     * @return Response
     */
    public function index(
        InstagramManager $instagram,
        TrackRepository $trackRepository,
        AlbumRepository $albumRepository
    ) {
        $medias = $instagram->getUserMedia('1097866395');
        $instas = array_slice($medias->data, 0, 2);

        $albums = $albumRepository->model->has('recentTracks')->paginate(4);

        foreach($albums as $album) {
            $album->load('recentTracks');
        }

        $tracks = $trackRepository->model->paginate(10)->all();

        return view('home', compact('instas', 'tracks','albums'));
    }

}
