<?php namespace App\Src\Track;

use App\Core\BaseModel;
use App\Core\LocaleTrait;
use App\Src\Category\Category;
use App\Src\Meta\CountableTrait;
use App\Src\Meta\DownloadableTrait;

class Track extends BaseModel
{

    use LocaleTrait;

    use CountableTrait;

    use DownloadableTrait;

    protected $table = 'tracks';

    public $morphClass = 'Track';

    protected $localeStrings = ['name', 'description'];

    public $types = [
        'album'    => 'App\Src\Album\Album',
        'category' => 'App\Src\Category\Category',
    ];

    protected $guarded = ['id'];

    public function trackeable()
    {
        return $this->morphTo();
    }

    public function metas()
    {
        return $this->morphMany('App\Src\Meta\Meta', 'meta');
    }

    public function topTracks()
    {
        return $this->morphOne('App\Src\Meta\Meta',
            'meta')->selectRaw('meta_id, count(*) as count')->groupBy('meta_id')->orderBy('count', 'desc')->limit(1);
    }

    public function downloads()
    {
        return $this->morphMany('App\Src\Meta\Download', 'downloadable');
    }

    public function getTrackeableTypeAttribute($type)
    {
        $type = strtolower($type);

        return array_get($this->types, $type, $type);
    }


    public function getSizeAttribute($bytes)
    {

        if ($bytes >= 1073741824) {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            $bytes = $bytes . ' bytes';
        } elseif ($bytes == 1) {
            $bytes = $bytes . ' byte';
        } else {
            $bytes = '0 bytes';
        }

        return $bytes;
    }

    public function setTrackeableTypeAttribute($value)
    {
        $this->attributes['trackeable_type'] = ucfirst($value);
    }

    public function setSlugAttribute($value)
    {
        return $this->attributes['slug'] = slug($value);
    }


    /**
     * Get the Clean Name For Track (Strip Extensions, and Secure)
     * @param $value
     * @return string
     */
    public function setNameArAttribute($value)
    {
        $temp = explode('.', $value);
        $ext = array_pop($temp);
        $name = implode('.', $temp);
        $name = strip_tags(e($name));

        return $this->attributes['name_ar'] = slug($name);
    }

}
