<?php namespace App\Src\Album;

use App\Core\BaseModel;
use App\Core\LocaleTrait;
use App\Src\Meta\CountableTrait;

class Album extends BaseModel
{

    use LocaleTrait;

    use CountableTrait;

    protected $table = 'albums';

    protected $morphClass = 'Album';

    public $rules = ['name_ar' => 'required|unique:albums,name_ar', 'category_id' => 'required:numeric|not_in:0'];

    protected $guarded = ['id'];

    protected $localeStrings = ['name', 'description'];


    public function category()
    {
        return $this->belongsTo('App\Src\Category\Category', 'category_id');
    }

    public function tracks()
    {
        return $this->morphMany('App\Src\Track\Track', 'trackeable')->orderBy('created_at', 'desc');
    }

    public function metas()
    {
        return $this->morphMany('App\Src\Meta\Meta', 'meta');
    }


    public function recentTracks()
    {
        return $this->morphMany('App\Src\Track\Track', 'trackeable')->orderBy('created_at', 'desc')->take(5);
    }

    public function photos()
    {
        return $this->morphMany('App\Src\Photo\Photo', 'imageable');
    }
}
