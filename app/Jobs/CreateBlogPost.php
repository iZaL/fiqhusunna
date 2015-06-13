<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Src\Blog\BlogRepository;
use App\Src\Photo\PhotoRepository;
use Illuminate\Contracts\Bus\SelfHandling;
use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;


class CreateBlogPost extends Job implements SelfHandling
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
        $blog = $blogRepository->model->create([
            'title_ar'       => $this->request->title_ar,
            'description_ar' => $this->request->description_ar,
            'user_id'        => Auth::user()->id,
            'slug'           => str_slug($this->request->title_ar)
        ]);

        if ($this->request->hasFile('cover')) {
            $file = $this->request->file('cover');

            $photoRepository->attach($file, $blog, ['thumbnail' => 1]);
        }
    }
}
