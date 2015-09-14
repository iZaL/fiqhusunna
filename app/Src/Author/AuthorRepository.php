<?php namespace App\Src\Author;

use App\Core\BaseRepository;

class AuthorRepository extends BaseRepository
{

    public $model;

    /**
     * Construct
     * @param Author $model
     */
    public function __construct(Author $model)
    {
        $this->model = $model;
    }

}