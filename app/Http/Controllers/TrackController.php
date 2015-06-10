<?php

namespace App\Http\Controllers;

use App\Src\Track\TrackManager;
use App\Src\Track\TrackRepository;

class TrackController extends Controller
{
    /**
     * @var TrackRepository
     */
    private $trackRepository;
    /**
     * @var TrackUploader
     */
    private $trackManager;

    /**
     * @param TrackRepository $trackRepository
     * @param TrackManager $trackManager
     */
    public function __construct(TrackRepository $trackRepository, TrackManager $trackManager)
    {
        $this->trackRepository = $trackRepository;
        $this->trackManager = $trackManager;
    }

    public function show($id)
    {
        $track = $this->trackRepository->model->find($id);

        $trackUrl = $this->trackManager->fetchTrack($track);

        return view('modules.track.view', compact('track', 'trackUrl'));
    }
}
