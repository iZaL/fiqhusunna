<?php

namespace App\Jobs;

use App\Http\Requests\Request;
use App\Jobs\Job;
use App\Src\Track\TrackManager;
use App\Src\Track\TrackRepository;
use Illuminate\Contracts\Bus\SelfHandling;

class UploadTrack extends Job implements SelfHandling
{
    /**
     * @var Request
     */
    private $request;
    /**
     * @var TrackRepository
     */

    /**
     * Create a new job instance.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Execute the job.
     *
     * @param TrackRepository $trackRepository
     * @param TrackManager $trackManager
     */
    public function handle(TrackRepository $trackRepository, TrackManager $trackManager)
    {
        foreach ($this->request->file('tracks') as $file) {


            // do not upload disallowed extensions
            if (!in_array($file->getClientOriginalExtension(), $trackManager->getAllowedExtension())) {
                continue;
            }

            $track = $trackRepository->model->create(array_merge([
                'trackeable_id'   => $this->request->trackeable_id,
                'trackeable_type' => $this->request->trackeable_type,
                'name_ar'         => $trackManager->getTrackName($file->getClientOriginalName()),
                'slug'            => $trackManager->getTrackSlug($file->getClientOriginalName()),
                'url'             => $trackRepository->setHashedName($file)->getHashedName(),
                'extension'       => $file->getClientOriginalExtension(),
                'size'            => $file->getClientSize(),
            ], $this->request->except('tracks')));

            // move uploaded file

            $trackManager->uploadTrack($file, $track);

        }
    }

}
