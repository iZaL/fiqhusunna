<?php

namespace App\Http\Controllers;

use App\Src\Track\TrackManager;
use App\Src\Track\TrackRepository;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;

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

    public function index()
    {
        return redirect('home');
    }

    public function show($id)
    {
        $track = $this->trackRepository->model->find($id);

        try {
            $trackUrl = $this->trackManager->fetchTrack($track);
        } catch (\Exception $e) {
            return redirect('home')->with('warning', 'Track Could Not Be loaded. Try again');
        }

        // uncomment this line for production use
        $trackUrl = '/test.mp3';

        // CountableTrait
        $track->incrementViewCount();

        return view('modules.track.view', compact('track', 'trackUrl'));
    }

    public function downloadTrack($id)
    {
        $track = $this->trackRepository->model->find($id);

        // Get The Track to Download
        try {
            $trackPath = $this->trackManager->downloadTrack($track);
        } catch (\Exception $e) {
            return redirect('home')->with('warning', 'Track Could Not Be Download. Try again');
        }

        // Set Name For the Track
        $downloadName = $track->name . '.' . $track->extension;

        $track->incrementDownloadCount();

        // uncomment this line for production use
        $trackPath = public_path().'/test.mp3';
        $downloadName = 'test.mp3';

        return response()->download($trackPath, $downloadName);
    }
}
