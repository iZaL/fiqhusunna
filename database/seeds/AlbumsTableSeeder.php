<?php

use App\Src\User\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AlbumsTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\Src\Album\Album',1)->create();
    }
}