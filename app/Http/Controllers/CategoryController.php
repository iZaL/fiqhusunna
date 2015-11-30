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

        dd(App::getLocale());
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
        ])->find($id);

        $category->incrementViewCount();

        return view('modules.category.track.view', compact('category'));
    }

    public function getArticle($id)
    {
        $blogCategories = $this->categoryRepository->model->has('blogs')->get();
        $category = $this->categoryRepository->model->with(['blogs.thumbnail'])->find($id);
        $articles= $category->blogs;
        return view('modules.category.article.view', compact('articles','blogCategories','category'));
    }


}
