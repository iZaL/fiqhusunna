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
        $parentCategories = $this->categoryRepository->model->parentCategories()->with('childCategories')->has('tracks','<',1)->get(['id','name_en']);
        $articles = $this->blogRepository->model->latest()->paginate(20);
        $selectedCategory = null;
        return view('modules.blog.index', compact('articles','parentCategories','selectedCategory'));
    }

    public function show($id)
    {
        // find category
        $parentCategories = $this->categoryRepository->model->parentCategories()->with('childCategories')->has('tracks','<',1)->get(['id','name_en']);
        $article = $this->blogRepository->model->with('photos')->find($id);
        $selectedCategory = $article->category;

        $article->incrementViewCount();
        return view('modules.blog.view', compact('article','selectedCategory','parentCategories'));
    }

}
