<?php namespace App\Src\Category;

use App\Core\BaseModel;
use App\Core\LocaleTrait;
use App\Src\Blog\Blog;
use App\Src\Meta\CountableTrait;
use Illuminate\Support\Facades\DB;

class Category extends BaseModel
{

    use LocaleTrait;

    use CountableTrait;

    protected $table = 'categories';

    public $morphClass = 'Category';

    protected $guarded = ['id'];

    protected $localeStrings = ['name', 'description'];

    /*********************************************************************************************************
     * Eloquent Relations
     ********************************************************************************************************/
    public function albums()
    {
        return $this->hasMany('App\Src\Album\Album');
    }

    public function parentCategories()
    {
        return $this->where('parent_id','=',0);
    }

    public function childCategories()
    {
        return $this->hasMany($this,'parent_id');
    }

    public function parentCategory()
    {
        return $this->belongsTo($this,'parent_id');
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }

    public function tracks()
    {
        return $this->morphMany('App\Src\Track\Track', 'trackeable');
    }

    public function photos()
    {
        return $this->morphMany('App\Src\Photo\Photo', 'imageable');
    }

    public function thumbnail()
    {
        return $this->morphOne('App\Src\Photo\Photo', 'imageable')->where('thumbnail', 1);
    }

    public function metas()
    {
        return $this->morphMany('App\Src\Meta\Meta', 'meta');
    }

}
