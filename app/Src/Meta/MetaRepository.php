<?php namespace App\Src\Meta;

use App\Core\BaseRepository;

class MetaRepository extends BaseRepository
{

    public $model;

    /**
     * Construct
     * @param Meta $model
     */
    public function __construct(Meta $model)
    {
        $this->model = $model;
    }

}