<?php

namespace App\Http\Controllers;

use App\Src\Category\CategoryRepository;
use App\Src\Track\TrackManager;
use Storage;

class CategoryController extends Controller
{

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
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

    public function show($id, TrackManager $trackManager)
    {
        $category = $this->categoryRepository->model->with([
            'albums.thumbnail',
            'tracks' => function ($q) {
                $q->latest()->limit(100);
            }
        ])->find($id);

        $category->incrementViewCount();

        return view('modules.category.view', compact('category'));
    }

}
