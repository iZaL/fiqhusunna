<?php

use App\Src\User\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TracksTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\Src\Track\Track',10)->create();
    }
}