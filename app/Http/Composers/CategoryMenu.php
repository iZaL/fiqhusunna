<?php
namespace App\Http\Composers;

use App\Src\Category\CategoryRepository;
use Illuminate\Contracts\View\View;

class CategoryMenu {
    
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function compose(View $view)
    {
        $categories = $this->categoryRepository->model->with('albums')->get(['id','name_ar']);
        $view->with('categories', $categories);
    }
    
}