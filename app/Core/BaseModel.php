<?php
namespace App\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BaseModel extends Model
{
    public function getDates()
    {
        return ['created_at', 'deleted_at', 'updated_at', 'date', 'record_date'];
    }

    public function setSlugAttribute($value)
    {
        return $this->attributes['slug'] = slug($value);
    }

}