<?php

namespace App\Http\Controllers;

use App\Src\Track\TrackRepository;
use App\Src\Track\TrackUploader;

class TrackController extends Controller
{
    /**
     * @var TrackRepository
     */
    private $trackRepository;
    /**
     * @var TrackUploader
     */
    private $trackUploader;

    /**
     * @param TrackRepository $trackRepository
     * @param TrackUploader $trackUploader
     */
    public function __construct(TrackRepository $trackRepository, TrackUploader $trackUploader)
    {
        $this->trackRepository = $trackRepository;
        $this->trackUploader = $trackUploader;
    }

    public function show($id)
    {
        $track = $this->trackRepository->model->find($id);

        $trackPath = $this->trackUploader->getTrackPath();

//        dd($trackPath.'/cafe-music/'.$track->url);
//        dd(is_file($trackPath.'/cafe-music/'.$track->url));
        return view('modules.track.view', compact('track', 'trackPath'));
    }
}
