<?php
namespace App\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use StdClass;
use Illuminate\Support\MessageBag;

abstract class BaseRepository
{
    protected $hashedName;

    public function getHashedName()
    {
        return $this->hashedName;
    }

    public function setHashedName($file)
    {
        $this->hashedName = md5(uniqid(rand() * (time()))) . '.' . $file->getClientOriginalExtension();
        return $this;
    }

}
