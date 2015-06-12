<?php

namespace App\Http\Controllers;

use App\Src\Album\AlbumRepository;
use App\Src\Meta\MetaRepository;
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
     * @param MetaRepository $metaRepository
     * @return Response
     */
    public function index(
        InstagramManager $instagram,
        TrackRepository $trackRepository,
        AlbumRepository $albumRepository,
        MetaRepository $metaRepository
    ) {
        $medias = $instagram->getUserMedia('1097866395');
        $instas = array_slice($medias->data, 0, 2);

        $albums = $albumRepository->model->has('recentTracks')->paginate(4);

        foreach ($albums as $album) {
            $album->load('recentTracks');
        }

        // Get all Tracks
        $tracks = $trackRepository->model->with('metas')->get();

        // Fetch Latest Added Tracks
        $latestTracks = $tracks->sortByDesc('created_at')->take(10);

        // Get Top Tracks For All Time
        $topTracks = $metaRepository->model->getTopTracks();
        $topTracks = array_pluck($topTracks, 'meta_id');
        $topTracks = $trackRepository->model->whereIn('id', $topTracks)->get()->reverse();

        // Get Top Tracks For Today
        $topTracksForToday = $metaRepository->model->getTopTracks('today');
        $topTracksForToday = array_pluck($topTracksForToday, 'meta_id');
        $topTracksForToday = $trackRepository->model->whereIn('id', $topTracksForToday)->get()->reverse();

        // Get Top Tracks For This Month
        $topTracksForThisMonth = $metaRepository->model->getTopTracks('this-month');
        $topTracksForThisMonth = array_pluck($topTracksForThisMonth, 'meta_id');
        $topTracksForThisMonth = $trackRepository->model->whereIn('id', $topTracksForThisMonth)->get()->reverse();


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
