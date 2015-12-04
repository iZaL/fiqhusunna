<?php
namespace App\Http\Composers;

use App\Src\Category\CategoryRepository;
use Illuminate\Contracts\View\View;

class TrackCategory {

    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function compose(View $view)
    {
        $categories = $this->categoryRepository->model->with('albums')->where('type','track')->get(['id','name_en']);
        $view->with('trackCategories', $categories);
    }

}