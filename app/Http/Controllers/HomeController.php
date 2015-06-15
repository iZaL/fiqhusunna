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
//        $medias = $instagram->getUserMedia('1097866395');
//        $instas = array_slice($medias->data, 0, 4);

        $albums = $albumRepository->model->paginate(4);

        // @todo : Eager load the relation
        foreach($albums as $album) {
            $album->load('recentTracks');
        }

        // Get all Tracks
        $latestTracks = $trackRepository->model->with('metas')->orderBy('created_at', 'desc')->paginate(10);

        // Get Top Tracks For All Time
        $topTracks = $trackRepository->getTopTracks();

        // Get Top Tracks For Today
        $topTracksForToday = $trackRepository->getTopTracks('today');

        // Get Top Tracks For This Month
        $topTracksForThisMonth = $trackRepository->getTopTracks('this-month');

        // Do No Return Empty Records
        if (!count($topTracksForToday)) {
            $topTracksForToday = $topTracks;
        }

        if (!count($topTracksForThisMonth)) {
            $topTracksForThisMonth = $topTracks;
        }

        return view('home',
            compact('instas', 'albums', 'latestTracks', 'topTracks', 'topTracksForToday', 'topTracksForThisMonth'));
    }

}
