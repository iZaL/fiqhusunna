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
    )
    {
        $medias = $instagram->getUserMedia('1791483929');
        $instas = array_slice($medias->data, 0, 3);

        // Get all Tracks
        $latestTracks = $trackRepository->model->with('metas')->orderBy('created_at', 'desc')->paginate(50);

        return view('home', compact('instas', 'latestTracks', 'topTracks'));

    }
//    public function index(
//        InstagramManager $instagram,
//        TrackRepository $trackRepository,
//        AlbumRepository $albumRepository
//    ) {
//        $medias = $instagram->getUserMedia('1791483929');
//        $instas = array_slice($medias->data, 0, 4);
//
//        $albums = $albumRepository->model->has('recentTracks')->latest()->paginate(4);
//        // @todo : Eager load the relation
//        foreach ($albums as $album) {
//            $album->load('recentTracks');
//        }
//
//        $topAlbums = $albumRepository->model->getTopAlbums('all', 10);
//
//        $topAlbumsForThisMonth = $albumRepository->model->getTopAlbums('this-month', 10);
//
//        // Get all Tracks
//        $latestTracks = $trackRepository->model->with('metas')->orderBy('created_at', 'desc')->paginate(10);
//
//        // Get Top Tracks For All Time
//        $topTracks = $trackRepository->model->getTopTracks('all', 10);
//
//        // Get Top Tracks For Today
//        $topTracksForToday = $trackRepository->model->getTopTracks('today', 10);
//
//        // Get Top Tracks For This Month
//        $topTracksForThisMonth = $trackRepository->model->getTopTracks('this-month', 10);
//
//
//        return view('home',
//            compact('instas', 'albums', 'latestTracks', 'topTracks', 'topTracksForToday', 'topTracksForThisMonth','topAlbums','topAlbumsForThisMonth'));
//    }

}
