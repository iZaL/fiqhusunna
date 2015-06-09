<?php namespace App\Src\Favorite;

use App\Core\BaseRepository;

class FavoriteRepository extends BaseRepository
{

    public $model;

    /**
     * Construct
     * @param Favorite $model
     */
    public function __construct(Favorite $model)
    {
        $this->model = $model;
    }

}