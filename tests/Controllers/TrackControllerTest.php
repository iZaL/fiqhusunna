<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\App;

//
class TrackControllerTest extends TestCase
{

    use DatabaseTransactions;
    use WithoutMiddleware;

    protected $trackManager;
    protected $user;
    protected $catName;
    protected $albumName;
    protected $category;

    public function setUp()
    {
        parent::setUp();

        $this->trackManager = App::make('\App\Src\Track\TrackManager');
        $user = factory('App\Src\User\User')->make();
        $this->catName = uniqid();
        $this->category = \App\Src\Category\Category::create([
            'name_en'        => $this->catName,
            'name_ar'        => $this->catName,
            'slug'           => str_slug($this->catName),
            'description_ar' => 'description',
            'description_en' => 'description',
        ]);
        $this->user = $this->be($user);

    }

    public function testStore()
    {
        //
        if (!file_exists($this->trackManager->getRelativePath() . '/' . $this->category->slug)) {
            mkdir($this->trackManager->getRelativePath() . '/' . $this->category->slug);
        }
        $this->visit('/admin/track/create?type=category')
            ->type('category', 'trackeable_type')
            ->type($this->category->id, 'trackeable_id')
            ->attach($this->trackManager->getRelativePath() . '/test.mp3', 'tracks[]')
            ->press('Save');

        $this->seeInDatabase('tracks',
            [
                'trackeable_id'   => $this->category->id,
                'trackeable_type' => 'Category'
            ]);

        $track = \App\Src\Track\Track::where('trackeable_id', $this->category->id)->where('trackeable_type',
            'Category')->first();

//        $this->assertFileExists($this->trackManager->getRelativePath() . '/' . $this->category->slug . '/' . $track->url);
//
//        rmdir($this->trackManager->getRelativePath() . '/' . $this->category->slug . '/' . $track->url);
        rmdir($this->trackManager->getRelativePath() . '/' . $this->category->slug);

        $this->onPage('/admin/track');
    }


//    public function testUpdatedViewCount()
//    {
//        \App\Src\Track\Track::create([
//            'trackeable_id'   => 1,
//            'trackeable_type' => 'Category',
//            'name_ar'         => 'ass'
//        ]);
//        $track =  \App\Src\Track\Track::all()->first();
//
//        $this->visit('/track/'.$track->id);
//        $this->seeInDatabase('metas', ['meta_id' => 1, 'meta_type', 'Track']);
//        $this->visit('/track/1');
////
//        $track = \App\Src\Track\Track::all();
//        $this->assertEquals(1, $track->count());
//    }
}
