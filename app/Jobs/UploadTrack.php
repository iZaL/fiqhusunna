<?php

namespace App\Jobs;

use App\Http\Requests\Request;
use App\Src\Track\TrackManager;
use App\Src\Track\TrackRepository;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Support\Facades\App;

class UploadTrack extends Job implements SelfHandling
{

    // MAX parallel upload count per task
    const MAX_UPLOAD_COUNT = 5;

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
        $uploadCount = 1;

        foreach ($this->request->file('tracks') as $file) {

            // guard the max upload counts per task
            if ($uploadCount > self::MAX_UPLOAD_COUNT) {
                break;
            }

            // do not upload disallowed extensions
            if (!in_array($file->getClientOriginalExtension(), $trackManager->getAllowedExtension())) {
                continue;
            }

            $trackRepository = App::make('App\Src\Track\TrackRepository');

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
            $trackManager->uploadTrack($file, $track);

            $track->save();

            $uploadCount++;
        }
    }

}
