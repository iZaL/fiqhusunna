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
        $track->increment('views');
        $track->save();

        $trackUrl = $this->trackManager->fetchTrack($track);

        return view('modules.track.view', compact('track', 'trackUrl'));
    }

    public function downloadTrack($id)
    {
        $track = $this->trackRepository->model->find($id);

        // Increment Download Count
        $track->increment('downloads');
        $track->save();

        // Set Name For the Track
        $downloadName = $track->name . '.' . $track->extension;

        // Get The Track to Download
        $trackPath = $this->trackManager->downloadTrack($track);

        return response()->download($trackPath, $downloadName);
    }
}
