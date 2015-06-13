<?php namespace App\Src\Meta;

use App\Core\BaseModel;

class Meta extends BaseModel
{

    protected $table = 'metas';

    protected $guarded = ['id'];


    public $types = [
        'album'    => 'App\Src\Album\Album',
        'category' => 'App\Src\Category\Category',
        'track'    => 'App\Src\Track\Track',
    ];

    public function meta()
    {
        return $this->morphTo();
    }

    public function getMetaTypeAttribute($type)
    {
        $type = strtolower($type);

        return array_get($this->types, $type, $type);
    }


    public function scopeOfType($query, $type)
    {
        return $query->where('meta_type', $type);
    }

}
