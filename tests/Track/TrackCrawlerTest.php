<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\App;

class TrackCrawlerTest extends TestCase
{

    use DatabaseTransactions;

    protected $trackCrawler;

    public function setUp()
    {
        parent::setUp();

        $this->trackCrawler = App::make('\App\Src\Track\TrackCrawler');
    }
    public function  testItWorks()
    {
        $this->visit('/')->see('Sound App');
    }

//    public function testSyncTracks()
//    {
//        $this->trackUploader->syncTracks();
//        $this->seeInDatabase('categories', ['name_ar' => 'a']);
//        $this->seeInDatabase('categories', ['name_ar' => 'b']);
//        $this->seeInDatabase('albums', ['name_ar' => 'a1']);
//        $this->seeInDatabase('albums', ['name_ar' => 'b1']);
//        $this->seeInDatabase('tracks', ['title_ar' => 'a1.mp3', 'url' => 'a1.mp3']);
//    }

}
