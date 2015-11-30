<?php

namespace App\Http\Controllers;

use App\Src\Blog\BlogRepository;
use App\Src\Category\CategoryRepository;

class BlogController extends Controller
{

    /**
     * @var CategoryRepository
     */
    private $blogRepository;
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * @param BlogRepository $blogRepository
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(BlogRepository $blogRepository,CategoryRepository $categoryRepository)
    {
        $this->blogRepository = $blogRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */
    public function index()
    {
        $parentCategories = $this->categoryRepository->model->parentCategories()->has('tracks','<',1)->get();
        $articles = $this->blogRepository->model->latest()->paginate(20);
        return view('modules.blog.index', compact('articles','parentCategories'));
    }

    public function show($id)
    {
        $category = $this->categoryRepository->model->with('childCategories')->find($id);
        $post = $this->blogRepository->model->with('photos')->find($id);
        $post->incrementViewCount();

        return view('modules.blog.view', compact('post','category'));
    }

}
