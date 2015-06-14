<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class BlogControllerTest extends TestCase
{

    use DatabaseTransactions;
    use WithoutMiddleware;

    protected $user;

    /**
     * @var
     */
    private $faker;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory('App\Src\User\User', 1)->create(['email' => uniqid() . '@email.com']);

    }

    public function testStore()
    {
        $title = uniqid();
        $this->actingAs($this->user)
            ->visit('/admin/blog/create')
            ->type($title, 'title_ar')
            ->type('description', 'description_ar')
            ->attach(public_path() . '/img/test.jpg', 'cover')
            ->press('Save');

        $this->seeInDatabase('blogs',
            [
                'title_ar'       => $title,
                'description_ar' => 'description',
                'slug'           => str_slug($title)
            ]);

        $blog = \App\Src\Blog\Blog::where('title_ar', $title)->first();

        $this->seeInDatabase('photos', ['imageable_type' => 'Blog', 'imageable_id' => $blog->id]);

        $photos = \App\Src\Photo\Photo::where('imageable_type', 'Blog')->where('imageable_id',
            $blog->id)->first();

        $this->fileExists(base_path(public_path() . '/uploads/thumbnail/' . $photos->name));

        unlink(public_path() . '/uploads/thumbnail/' . $photos->name);

        $this->onPage('/admin/blog');
    }

}
