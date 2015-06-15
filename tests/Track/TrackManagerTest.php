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
        $this->user = factory('App\Src\User\User', 1)->create(['email' => uniqid() . '@email.com']);

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
        $trackDir = uniqid();

        $trackUrl = uniqid() . '.mp3';

        $category = factory('App\Src\Category\Category', 1)->create([
            'name_ar' => $catDir
        ]);

        $track = factory('App\Src\Track\Track', 1)->create([
            'name_ar'       => $trackDir,
            'slug'          => $trackDir,
            'url'           => $trackUrl,
            'trackeable_id' => $category->id
        ]);

        $file = new \Symfony\Component\HttpFoundation\File\UploadedFile($file, $track->url);

        $this->trackManager->createCategoryDirectory($category->slug);

        $this->trackManager->uploadTrack($file, $track);

        $this->assertFileExists($this->trackManager->getRelativePath() . '/' . $category->slug);
        $this->assertFileExists($this->trackManager->getRelativePath() . '/' . $category->slug . '/' . $track->url);
        rmdir($this->trackManager->getRelativePath() . '/' . $category->slug . '/' . $track->url);
        rmdir($this->trackManager->getRelativePath() . '/' . $category->slug);
    }
}
