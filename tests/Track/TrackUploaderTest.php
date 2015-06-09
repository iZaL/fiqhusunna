<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\App;

class TrackUploaderTest extends TestCase
{

//    use DatabaseTransactions;

    protected $trackUploader;
    protected $catName;

    public function __construct()
    {
        parent::setUp();

        $this->trackUploader = App::make('\App\Src\Track\TrackUploader');
        $this->catName = uniqid();
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
        $this->trackUploader->createCategoryDirectory($catDir);
        $this->assertFileExists($this->trackUploader->getUploadPath() . '/' . $catDir);
        rmdir($this->trackUploader->getUploadPath() . '/' . $catDir);
    }

    public function testCreateAlbumDirectory()
    {
        $catDir = uniqid();
        $albumDir = uniqid();
        $this->trackUploader->createCategoryDirectory($catDir);
        $this->trackUploader->createAlbumDirectory($catDir, $albumDir);
        $this->assertFileExists($this->trackUploader->getUploadPath() . '/' . $catDir . '/' . $albumDir);
        rmdir($this->trackUploader->getUploadPath() . '/' . $catDir . '/' . $albumDir);
        rmdir($this->trackUploader->getUploadPath() . '/' . $catDir);
    }

    public function testCreateCategoryTrack()
    {
        $file = $this->trackUploader->getUploadPath() . '/test.mp3';

        $file = new \Symfony\Component\HttpFoundation\File\UploadedFile($file, 'test.mp3');

        $track = \App\Src\Track\Track::create([
            'title_ar'        => 'test',
            'url'             => 'test.mp3',
            'user_id'         => 1,
            'slug'            => 'test.mp3',
            'trackeable_id'   => 1,
            'trackeable_type' => 'Category'
        ]);

        $this->trackUploader->createCategoryDirectory($this->catName);
        $this->trackUploader->createCategoryTrack($file, $track, $this->catName);

        $this->assertFileExists($this->trackUploader->getUploadPath() . '/' . $this->catName);
        $this->assertFileExists($this->trackUploader->getUploadPath() . '/' . $this->catName . '/' . $track->title);
        rmdir($this->trackUploader->getUploadPath() . '/' . $this->catName . '/' . $track->slug);
        rmdir($this->trackUploader->getUploadPath() . '/' . $this->catName);
    }
}
