<?php

namespace App\Http\Controllers;

use App\Src\Blog\BlogRepository;
use App\Src\Category\CategoryRepository;
use App\Src\Track\TrackManager;
use Illuminate\Support\Facades\App;
use Storage;

class CategoryController extends Controller
{

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;
    /**
     * @var BlogRepository
     */
    private $blogRepository;

    /**
     * CategoryController constructor.
     * @param CategoryRepository $categoryRepository
     * @param BlogRepository $blogRepository
     */
    public function __construct(CategoryRepository $categoryRepository,BlogRepository $blogRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->blogRepository = $blogRepository;
    }

    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */
    public function index()
    {
        return view('modules.category.index');
    }

    public function getTrack($id, TrackManager $trackManager)
    {
        $category = $this->categoryRepository->model->with([
            'albums.thumbnail',
            'tracks' => function ($q) {
                $q->latest()->limit(100);
            }
        ])->where('type','track')->find($id);

        $category->incrementViewCount();

        return view('modules.category.track.view', compact('category'));
    }

    public function getArticle($id)
    {
        // get all parent categories for aricles
        $parentCategories =  $this->categoryRepository->model->parentCategories()->with(['childCategories'=>function($q) {
            $q->where('type','blog');
        }])->where('type','blog')->get(['id','name_en']);

        $selectedCategory = $this->categoryRepository->model->with(['blogs.thumbnail'])->findOrFail($id);

        if($selectedCategory->isParent()) {
            $childCategories = array_merge([$selectedCategory->id], $selectedCategory->childCategories->modelKeys());
            $articles = $this->blogRepository->model->whereIn('category_id',$childCategories)->get();
        } else {
            $articles= $selectedCategory->blogs;
        }
        return view('modules.blog.index', compact('articles','parentCategories','selectedCategory'));
    }


}
