<?php
namespace App\Core;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    public function getDates()
    {
        return ['created_at', 'deleted_at', 'updated_at', 'date'];
    }
}