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
        if (App::environment() == 'local') {
            Model::unguard();
            $this->cleanDatabase();
            factory('App\Src\User\User', 1)->create();
//            factory('App\Src\Category\Category', 5)->create();
//            factory('App\Src\Album\Album', 10)->create();
//            factory('App\Src\Track\Track', 1000)->create();
//            factory('App\Src\Blog\Blog', 50)->create();
        }
    }

    private function cleanDatabase()
    {
        foreach ($this->tables as $table) {
            DB::table($table)->truncate();
        }
    }

}
