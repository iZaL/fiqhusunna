<?php namespace App\Src\Category;

use App\Core\BaseModel;
use App\Core\LocaleTrait;
use App\Src\Meta\CountableTrait;

class Category extends BaseModel
{

    use LocaleTrait;

    use CountableTrait;

    protected $table = 'categories';

    public $rules = ['name_ar' => 'required'];

    protected $morphClass = 'Category';

    protected $guarded = ['id'];

    protected $localeStrings = ['name', 'description'];

    /*********************************************************************************************************
     * Eloquent Relations
     ********************************************************************************************************/
    public function albums()
    {
        return $this->hasMany('App\Src\Album\Album');
    }

    public function tracks()
    {
        return $this->morphMany('App\Src\Track\Track', 'trackeable');
    }

    public function photos()
    {
        return $this->morphMany('App\Src\Photo\Photo', 'imageable');
    }

    public function metas()
    {
        return $this->morphMany('App\Src\Meta\Meta', 'meta');
    }
}
