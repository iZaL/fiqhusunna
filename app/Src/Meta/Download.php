<?php namespace App\Src\Meta;

use App\Core\BaseModel;
use App\Core\LocaleTrait;

class Download extends BaseModel
{

    protected $table = 'downloads';

    protected $guarded = ['id'];


    public $types = [
        'track' => 'App\Src\Track\Track',
    ];

    public function downloadable()
    {
        return $this->morphTo();
    }

    public function getDownloadableTypeAttribute($type)
    {
        $type = strtolower($type);

        return array_get($this->types, $type, $type);
    }


}
