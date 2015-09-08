<?php

namespace App\Jobs;

use App\Http\Requests\Request;
use App\Src\Track\TrackManager;
use App\Src\Track\TrackRepository;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Support\Facades\App;

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
     * @param TrackManager $trackManager
     */
    public function handle(TrackManager $trackManager)
    {
        foreach ($this->request->file('tracks') as $file) {

            // do not upload disallowed extensions
            if (!in_array($file->getClientOriginalExtension(), $trackManager->getAllowedExtension())) {
                continue;
            }

            $trackRepository  = App::make('App\Src\Track\TrackRepository');

            $track = $trackRepository->model->fill(array_merge([
                'trackeable_id'   => $this->request->trackeable_id,
                'trackeable_type' => $this->request->trackeable_type,
                'name_ar'         => $file->getClientOriginalName(),
                'slug'            => $file->getClientOriginalName(),
                'url'             => $trackRepository->setHashedName($file)->getHashedName(),
                'extension'       => $file->getClientOriginalExtension(),
                'size'            => $file->getClientSize(),
            ], $this->request->except('tracks')));

            // move uploaded file
            $track->save();

            $track;

            $trackManager->uploadTrack($file, $track);

        }
    }

}
