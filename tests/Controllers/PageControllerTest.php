<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\App;

/**
* @property  trackManager
*/
class PageControllerTest extends TestCase
{

    public function testPages()
    {
        $this->call('get','/about');
        $this->assertResponseOk();

        $this->call('get','/contact');
        $this->assertResponseOk();

        $this->call('get','/blog');
        $this->assertResponseOk();

    }

}
