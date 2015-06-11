<?php
namespace App\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use StdClass;
use Illuminate\Support\MessageBag;

abstract class BaseRepository
{
    protected $hashedName;

    /**
     * @return mixed
     */
    public function getCategory()
    {
        $categoryRepository = App::make('App\Src\Category\CategoryRepository');
        $transactionModel = new \ReflectionClass($this->model);
        return $categoryRepository->model->where('name',ucfirst($transactionModel->getShortName()))->first();
    }

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
