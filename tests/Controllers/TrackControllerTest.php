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

    public function setUp()
    {
        parent::setUp();

        $this->trackManager = App::make('\App\Src\Track\TrackManager');
        $this->user = factory('App\Src\User\User', 1)->create(['email' => uniqid() . '@email.com']);
    }

    public function testIndex()
    {

    }

    public function testStore()
    {
        //
        $uniqueName = uniqid();
        $category = factory('App\Src\Category\Category', 1)->create([
            'name_ar' => $uniqueName,
            'slug'    => $uniqueName
        ]);

        if (!file_exists($this->trackManager->getRelativePath() . '/' . $category->slug)) {
            mkdir($this->trackManager->getRelativePath() . '/' . $category->slug);
        }

        $this->visit('/admin/track/create?type=category')
            ->type('category', 'trackeable_type')
            ->type($category->id, 'trackeable_id')
            ->attach($this->trackManager->getRelativePath() . '/test.mp3', 'tracks[]')
            ->press('Save');

        $this->seeInDatabase('tracks',
            [
                'trackeable_id'   => $category->id,
                'trackeable_type' => 'Category',
                'name_ar'         => $category->name
            ]);

        $track = \App\Src\Track\Track::where('trackeable_id', $category->id)->where('trackeable_type',
            'Category')->first();

        $this->assertFileExists($this->trackManager->getRelativePath() . '/' . $category->slug . '/' . $track->url);
//
        rmdir($this->trackManager->getRelativePath() . '/' . $category->slug . '/' . $track->url);
        rmdir($this->trackManager->getRelativePath() . '/' . $category->slug);

        $this->onPage('/admin/track');
    }


    public function testUpdateViewCount()
    {
        $track = factory('App\Src\Track\Track', 1)->create();
//        $meta = factory('App\Src\Meta\Meta', 1)->create(['meta_id' => $track->id]);
        $this->visit('/track/' . $track->id);
        $this->seeInDatabase('metas', ['meta_id' => $track->id, 'meta_type', 'Track']);
        $this->assertEquals(1, $track->count());

        $this->visit('/track/' . $track->id);
        $track = \App\Src\Meta\Meta::all();
        $this->assertEquals(1, $track->count());
    }
}
