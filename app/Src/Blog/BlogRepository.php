<?php namespace App\Src\Blog;

use App\Core\BaseRepository;

class BlogRepository extends BaseRepository
{

    public $model;

    /**
     * Construct
     * @param Blog $model
     */
    public function __construct(Blog $model)
    {
        $this->model = $model;
    }

    public function getSidebarPosts()
    {
        return $this->model->with('thumbnail')->paginate(4);
    }
}