<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\App;

class TrackManagerTest extends TestCase
{

    use DatabaseTransactions;

    protected $trackManager;

    public function setUp()
    {
        parent::setUp();

        $this->trackManager = App::make('\App\Src\Track\TrackManager');
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

    public function testCreateCategoryDirectory()
    {
        $catDir = uniqid();
        $this->trackManager->createCategoryDirectory($catDir);
        $this->assertFileExists($this->trackManager->getUploadPath() . '/' . $catDir);
        rmdir($this->trackManager->getUploadPath() . '/' . $catDir);
    }

    public function testCreateAlbumDirectory()
    {
        $catDir = uniqid();
        $albumDir = uniqid();
        $this->trackManager->createCategoryDirectory($catDir);
        $this->trackManager->createAlbumDirectory($catDir, $albumDir);
        $this->assertFileExists($this->trackManager->getUploadPath() . '/' . $catDir . '/' . $albumDir);
        rmdir($this->trackManager->getUploadPath() . '/' . $catDir . '/' . $albumDir);
        rmdir($this->trackManager->getUploadPath() . '/' . $catDir);
    }

    public function testCreateCategoryTrack()
    {
        $file = $this->trackManager->getUploadPath() . '/test.mp3';

        $catDir = uniqid();

        $file = new \Symfony\Component\HttpFoundation\File\UploadedFile($file, 'test.mp3');

        $track = \App\Src\Track\Track::create([
            'name_ar'        => 'test',
            'url'             => 'test.mp3',
            'slug'            => 'test.mp3',
            'trackeable_id'   => 1,
            'trackeable_type' => 'Category',
            'size'            => '12212'
        ]);

        $this->trackManager->createCategoryDirectory($catDir);
        $this->trackManager->createCategoryTrack($file, $track, $catDir);

        $this->assertFileExists($this->trackManager->getUploadPath() . '/' . $catDir);
//        $this->assertFileExists($this->trackManager->getTrackPath() . '/' . $catDir . '/' . $track->url);
//        rmdir($this->trackManager->getUploadPath() . '/' . $catDir . '/' . $track->url);
        rmdir($this->trackManager->getUploadPath() . '/' . $catDir);
    }
}
