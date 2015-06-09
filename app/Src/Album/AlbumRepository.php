<?php namespace App\Src\Album;

use App\Core\BaseRepository;

class AlbumRepository extends BaseRepository
{

    public $model;

    /**
     * Construct
     * @param Album $model
     */
    public function __construct(Album $model)
    {
        $this->model = $model;
    }

}