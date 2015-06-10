<?php namespace App\Src\Track;

use App\Core\BaseModel;
use App\Core\LocaleTrait;

class Track extends BaseModel
{

    use LocaleTrait;

    protected $table = 'tracks';

    protected $localeStrings = ['title', 'description'];

    public $types = [
        'album'    => 'App\Src\Album\Album',
        'category' => 'App\Src\Category\Category',
    ];

    protected $guarded = ['id'];

    public function trackeable()
    {
        return $this->morphTo();
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
}
