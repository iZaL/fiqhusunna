<?php namespace App\Src\Comment;

use App\Core\BaseRepository;

class CommentRepository extends BaseRepository
{

    public $model;

    /**
     * Construct
     * @param Comment $model
     */
    public function __construct(Comment $model)
    {
        $this->model = $model;
    }

}