<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\App;

class CategoryControllerTest extends TestCase
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


    public function testStore()
    {
        $catName = uniqid();

        $this->visit('/admin/category/create')
            ->type($catName, 'name_ar')
            ->type('description', 'description_ar')
            ->attach(public_path() . '/img/test.jpg', 'cover')
            ->press('Save');

        $this->seeInDatabase('categories',
            ['name_ar' => $catName, 'description_ar' => 'description', 'slug' => str_slug($catName)]);

        $category = \App\Src\Category\Category::where('name_ar', $catName)->first();

        // check folder exists
        $this->assertFileExists($this->trackManager->getRelativePath() . '/' . $category->slug);
        rmdir($this->trackManager->getRelativePath() . '/' . $category->slug);

        // check cat thumb image exists
        $this->seeInDatabase('photos', ['imageable_type' => 'Category', 'imageable_id' => $category->id]);

        $photos = \App\Src\Photo\Photo::where('imageable_type', 'Category')->where('imageable_id',
            $category->id)->first();

        // check image exist on server
        $this->fileExists(base_path(public_path() . '/uploads/thumbnail/' . $photos->name));
        unlink(public_path() . '/uploads/thumbnail/' . $photos->name);

        // redirect
        $this->onPage('/admin/category');
    }

    public function testUpdate()
    {
        $oldCategory = factory('App\Src\Category\Category', 1)->create();
        if (!file_exists($this->trackManager->getRelativePath() . '/' . $oldCategory->slug)) {
            mkdir($this->trackManager->getRelativePath() . '/' . $oldCategory->slug);
        }

        $catName = uniqid();

        $this->actingAs($this->user)
            ->visit('/admin/category/'.$oldCategory->id.'/edit')
            ->type($catName, 'name_ar')
            ->type('description', 'description_ar')
            ->attach(public_path() . '/img/test.jpg', 'cover')
            ->press('Save');

        $this->seeInDatabase('categories',
            ['name_ar' => $catName, 'description_ar' => 'description', 'slug' => str_slug($catName)]);

        $category = \App\Src\Category\Category::where('name_ar', $catName)->first();

        // check folder exists
        $this->assertFileNotExists($this->trackManager->getRelativePath() . '/' . $oldCategory->slug);

        $this->assertFileExists($this->trackManager->getRelativePath() . '/' . $category->slug);
        rmdir($this->trackManager->getRelativePath() . '/' . $category->slug);

        // check cat thumb image exists
        $this->seeInDatabase('photos', ['imageable_type' => 'Category', 'imageable_id' => $category->id]);

        $photos = \App\Src\Photo\Photo::where('imageable_type', 'Category')->where('imageable_id',
            $category->id)->first();

        // check image exist on server
        $this->fileExists(base_path(public_path() . '/uploads/thumbnail/' . $photos->name));
        unlink(public_path() . '/uploads/thumbnail/' . $photos->name);

        // redirect
        $this->onPage('/admin/category');
    }

}
