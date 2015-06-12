<?php


namespace App\Src\Meta;


use Carbon\Carbon;

trait DownloadableTrait
{


    public function incrementDownloadCount()
    {
        // get the meta type and ID
        // check if the result has been added in 24 hrs ? dont add. else create
        $userIP = $_SERVER['REMOTE_ADDR'];

        $this->downloads()->create(['ip' => $userIP]);

    }

    abstract function downloads();
}