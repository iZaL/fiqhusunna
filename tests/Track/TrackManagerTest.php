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

    public function testCreateCategoryDirectory()
    {
        $catDir = uniqid();
        $this->trackManager->createCategoryDirectory($catDir);
        $this->assertFileExists($this->trackManager->getRelativePath() . '/' . $catDir);
        rmdir($this->trackManager->getRelativePath() . '/' . $catDir);
    }

    public function testCreateAlbumDirectory()
    {
        $catDir = uniqid();
        $albumDir = uniqid();
        $this->trackManager->createCategoryDirectory($catDir);
        $this->trackManager->createAlbumDirectory($catDir, $albumDir);
        $this->assertFileExists($this->trackManager->getRelativePath() . '/' . $catDir . '/' . $albumDir);
        rmdir($this->trackManager->getRelativePath() . '/' . $catDir . '/' . $albumDir);
        rmdir($this->trackManager->getRelativePath() . '/' . $catDir);
    }

    public function testCreateCategoryTrack()
    {
        $file = $this->trackManager->getRelativePath() . '/test.mp3';

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
        $this->trackManager->uploadTrack($file, $track);

        $this->assertFileExists($this->trackManager->getRelativePath() . '/' . $catDir);
//        $this->assertFileExists($this->trackManager->getPublicPath() . '/' . $catDir . '/' . $track->url);
//        rmdir($this->trackManager->getRelativePath() . '/' . $catDir . '/' . $track->url);
        rmdir($this->trackManager->getRelativePath() . '/' . $catDir);
    }
}
