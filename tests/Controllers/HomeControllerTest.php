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

        $track = App::make(App\Src\Track\Track::class);

        $categories = factory('App\Src\Category\Category', 5)->create();

        $albums = factory('App\Src\Album\Album', 10)->create()
            ->each(function ($alb) {
                $alb->category()->associate(factory('App\Src\Category\Category')->create());
            });

        // to assosiate with track
        $trackeables = [$categories->random(), $albums->random()];
        $randomTrackeable = array_rand($trackeables);
        $trackeable = $trackeables[$randomTrackeable];


        $tracks = factory('App\Src\Track\Track', 100)->create([
            'trackeable_id'   => $trackeable->id,
            'trackeable_type' => $trackeable->morphClass
        ]);

        $this->visit('/')
            ->assertViewHasAll([
                'instas',
                'albums',
                'latestTracks',
                'topTracks',
                'topTracksForToday',
                'topTracksForThisMonth'
            ]);


        $this->assertEquals('5', $categories->count());
        $this->assertEquals('10', $albums->count());
        $this->assertEquals('100', $tracks->count());

    }

}
