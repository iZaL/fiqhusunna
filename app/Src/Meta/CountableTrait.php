<?php


namespace App\Src\Meta;


use Carbon\Carbon;

trait CountableTrait
{

    public function incrementViewCount()
    {
        // get the meta type and ID
        // check if the result has been added in 24 hrs ? dont add. else create
        $userIP = $_SERVER['REMOTE_ADDR'];

        $yesterday = new Carbon('yesterday');

        $hasUserVisitedToday = $this->metas()->where('ip', $userIP)->where('created_at', '>', $yesterday)->get();

        if (!count($hasUserVisitedToday)) {
            $this->metas()->create(['ip' => $userIP]);
        }

    }

    abstract function metas();
}