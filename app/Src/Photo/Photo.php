<?php
namespace App\Src\Photo;

use App\Core\BaseModel;

class Photo extends BaseModel
{

    public static $name = 'photo';

    protected $guarded = ['id'];

    protected $hidden = [];

    protected $table = 'photos';

    protected $types = [
        'album'    => 'App\Src\Album\Album',
        'category' => 'App\Src\Category\Category',
        'blog'     => 'App\Src\Blog\Blog',
    ];

    public function imageable()
    {
        return $this->morphTo();
    }

    public function getImageableTypeAttribute($type)
    {
        $type = strtolower($type);

        return array_get($this->types, $type, $type);
    }

}
