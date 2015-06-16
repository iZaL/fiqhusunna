<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{

    private $tables = [
        'users',
        'password_resets',
        'roles',
        'user_roles',
        'permissions',
        'role_permissions',
        'categories',
        'types',
        'albums',
        'tracks',
        'blogs',
        'metas',
        'downloads'
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            Model::unguard();
            $this->cleanDatabase();

            factory('App\Src\User\User', 1)->create();

            $categories = factory('App\Src\Category\Category', 10)->create();

            $albums = factory('App\Src\Album\Album', 10)->create()
                ->each(function ($alb) {
                    $alb->category()->associate(factory('App\Src\Category\Category')->create());
                });

            // to assosiate with track
            $trackeables = [$categories->random(), $albums->random()];
            $randomTrackeable = array_rand($trackeables);

            $trackeable = $trackeables[$randomTrackeable];

            factory('App\Src\Track\Track', 50)->create([
                'trackeable_id'   => $trackeable->id,
                'trackeable_type' => $trackeable->morphClass
            ]);

            factory('App\Src\Blog\Blog', 10)->create();
            factory('App\Src\Meta\Meta', 20)->create();

    }

    private function cleanDatabase()
    {
        foreach ($this->tables as $table) {
            DB::table($table)->truncate();
        }
    }

}
