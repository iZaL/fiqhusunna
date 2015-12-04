<?php
namespace App\Http\Composers;

use App\Src\Category\CategoryRepository;
use Illuminate\Contracts\View\View;

class ArticleCategory {
    
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function compose(View $view)
    {
        $categories = $this->categoryRepository->model->parentCategories()->with(['childCategories'=>function($q) {
            $q->where('type','!=','track');
        }])->get(['id','name_en']);
        $view->with('articleCategories', $categories);
    }
    
}