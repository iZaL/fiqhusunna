<?php
namespace App\Src\User;

use App\Core\BaseRepository;

class UserRepository extends BaseRepository
{

    public $model;

    /**
     * Construct
     * @param User $model
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

}