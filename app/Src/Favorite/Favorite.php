<?php namespace App\Src\Favorite;

use App\Core\BaseModel;

class Favorite extends BaseModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'favorites';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

}
