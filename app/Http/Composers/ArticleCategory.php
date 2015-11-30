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
        $categories = $this->categoryRepository->model->parentCategories()->with('childCategories')->has('blogs')->get(['id','name_ar']);
        $view->with('articleCategories', $categories);
    }
    
}