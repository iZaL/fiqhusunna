<?php namespace App\Src\Category;

use App\Core\BaseRepository;

class CategoryRepository extends BaseRepository
{

    public $model;

    /**
     * Construct
     * @param Category $model
     */
    public function __construct(Category $model)
    {
        $this->model = $model;
    }

}