<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\App;

//
class HomeControllerTest extends TestCase
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
        //
        $catName = uniqid();
        $albumName = uniqid();
        $trackName = uniqid() . '.mp3';

        $categories = factory('App\Src\Category\Category', 5)->create();

        $albums = factory('App\Src\Album\Album', 10)->create()
            ->each(function ($alb) {
                $alb->category()->associate(factory('App\Src\Category\Category')->create());
            });

        $trackCat = $categories->random();
        $trackAlbum = $albums->random();

        $trackeables = [$trackCat, $trackAlbum];
        $randomTrackeable = array_rand($trackeables);
        $trackeable= $trackeables[$randomTrackeable];

        $tracks = factory('App\Src\Track\Track', 100)->create(['trackeable_id'=>$trackeable->id, 'trackeable_type'=>$trackeable->morphClass]);

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
