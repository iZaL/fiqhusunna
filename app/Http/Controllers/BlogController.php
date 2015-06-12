<?php

namespace App\Http\Controllers;

use App\Src\Blog\BlogRepository;

class BlogController extends Controller
{

    /**
     * @var CategoryRepository
     */
    private $blogRepository;

    /**
     * @param BlogRepository $blogRepository
     */
    public function __construct(BlogRepository $blogRepository)
    {
        $this->blogRepository = $blogRepository;
    }

    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */
    public function index()
    {
        $blogs = $this->blogRepository->model->paginate(20);

        return view('modules.blog.index', compact('blogs'));
    }

    public function show($id)
    {
        $post = $this->blogRepository->model->with('photos')->find($id);

        return view('modules.blog.view', compact('post'));
    }

}
