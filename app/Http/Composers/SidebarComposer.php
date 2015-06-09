<?php

namespace App\Http\Composers;

use App\Src\Category\CategoryRepository;
use Illuminate\View\View;

class SidebarComposer
{
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;


    /**
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param View $view
     * @return $this
     */
    public function compose(View $view)
    {
        $categories = $this->categoryRepository->model->all();

        return $view->with('categories', $categories);
    }
}