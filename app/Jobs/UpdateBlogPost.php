<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Src\Blog\BlogRepository;
use App\Src\Photo\PhotoRepository;
use Illuminate\Contracts\Bus\SelfHandling;
use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;


class UpdateBlogPost extends Job implements SelfHandling
{
    /**
     * @var Request
     */
    private $request;

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
     * @param BlogRepository $blogRepository
     * @param PhotoRepository $photoRepository
     */
    public function handle(BlogRepository $blogRepository, PhotoRepository $photoRepository)
    {

    }
}
