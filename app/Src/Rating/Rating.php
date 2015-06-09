<?php namespace App\Src\Rating;

use App\Core\BaseModel;

class Rating extends BaseModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ratings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

}
