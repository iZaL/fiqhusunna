<?php namespace App\Src\Blog;

use App\Core\BaseModel;
use App\Core\LocaleTrait;
use App\Src\Category\Category;
use App\Src\Meta\CountableTrait;

class Blog extends BaseModel
{

    use LocaleTrait;
    use CountableTrait;

    protected $table = 'blogs';

    protected $morphClass = 'Blog';

    protected $guarded = ['id'];

    protected $localeStrings = ['title', 'description'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function photos()
    {
        return $this->morphMany('App\Src\Photo\Photo', 'imageable');
    }

    public function thumbnail()
    {
        return $this->morphOne('App\Src\Photo\Photo', 'imageable')->where('thumbnail', 1);
    }

    public function setSlugAttribute($value)
    {
        return $this->attributes['slug'] = slug($value);
    }

    public function metas()
    {
        return $this->morphMany('App\Src\Meta\Meta', 'meta');
    }

}
