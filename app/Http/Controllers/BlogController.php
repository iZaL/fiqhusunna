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
        return view('modules.blog.index');
    }

    public function show($id)
    {
        $blogs = $this->blogRepository->model->with('photos')->find($id);

        return view('modules.blog.view',compact('blogs'));
    }

}
