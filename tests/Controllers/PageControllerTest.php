<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PageControllerTest extends TestCase
{

    public function testHomePage()
    {
        $this->call('get','/home');
        $this->assertResponseOk();
    }

    public function testAboutPage()
    {
        $this->call('get','/about');
        $this->assertResponseOk();
    }

    public function testContactPage()
    {
        $this->call('get','/contact');
        $this->assertResponseOk();
    }

    public function testBlogPage()
    {
        $this->call('get','/blog');
        $this->assertResponseOk();
    }

}
