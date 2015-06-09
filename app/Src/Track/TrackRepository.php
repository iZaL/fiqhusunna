<?php namespace App\Src\Track;

use App\Core\BaseRepository;

class TrackRepository extends BaseRepository
{

    public $model;

    /**
     * Construct
     * @param Track $model
     */
    public function __construct(Track $model)
    {
        $this->model = $model;
    }

}