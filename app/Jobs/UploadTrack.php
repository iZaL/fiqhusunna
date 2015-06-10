<?php

namespace App\Jobs;

use App\Http\Requests\Request;
use App\Jobs\Job;
use App\Src\Track\TrackRepository;
use App\Src\Track\TrackUploader;
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
     * @param TrackUploader $trackUploader
     */
    public function handle(TrackRepository $trackRepository, TrackUploader $trackUploader)
    {
        //
        foreach ($this->request->file('tracks') as $file) {

            // do not upload disallowed extensions
            if (!in_array($file->getClientOriginalExtension(), $trackUploader->getAllowedExtension())) {
                continue;
            }

            $track = $trackRepository->model->create(array_merge([
                'user_id'         => 1,
                'trackeable_id'   => $this->request->trackeable_id,
                'trackeable_type' => $this->request->trackeable_type,
                'title_ar'        => $file->getClientOriginalName(),
                'slug'            => str_slug($file->getClientOriginalName()),
                'url'             => str_slug($file->getClientOriginalName()),
                'extension'       => $file->getClientOriginalExtension(),
                'size'            => $file->getClientSize(),
            ], $this->request->except('tracks')));

            // move uploaded file
            switch ($this->request->trackeable_type) {
                case 'category':
                    $trackUploader->createCategoryTrack($file, $track, $track->trackeable->slug);
                    break;
                case 'album':
                    $trackUploader->createAlbumTrack($file, $track,
                        $track->trackeable->category->slug,
                        $track->trackeable->slug);
                    break;
                default:
                    break;
            }
        }
    }

}
