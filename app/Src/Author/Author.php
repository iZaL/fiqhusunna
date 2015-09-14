<?php namespace App\Src\Author;

use App\Core\BaseModel;
use App\Core\LocaleTrait;
use App\Src\Meta\CountableTrait;
use Carbon\Carbon;

class Author extends BaseModel
{

    use LocaleTrait;
    use CountableTrait;

    protected $table = 'authors';

    protected $guarded = ['id'];

    protected $localeStrings = ['name','description'];

    public $morphClass = 'Author';

    public function metas()
    {
        return $this->morphMany('App\Src\Meta\Meta', 'meta');
    }

    public function photos()
    {
        return $this->morphMany('App\Src\Photo\Photo', 'imageable');
    }

    public function thumbnail()
    {
        return $this->morphOne('App\Src\Photo\Photo', 'imageable')->where('thumbnail', 1);
    }
}
