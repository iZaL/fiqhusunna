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
        $user = factory('App\Src\User\User')->make();
        $this->user = $this->be($user);
    }


    public function testCreateCategory()
    {
        $catName = 'a b' . uniqid();

        $this->visit('/admin/category/create')
            ->type($catName, 'name_ar')
            ->type('description', 'description_ar')
            ->attach(public_path() . '/img/product_02.jpg', 'cover')
            ->press('Save');

        $this->seeInDatabase('categories',
            ['name_ar' => $catName, 'description_ar' => 'description', 'slug' => str_slug($catName)]);

        $category = \App\Src\Category\Category::where('name_ar', $catName)->first();

        $this->assertFileExists($this->trackManager->getUploadPath() . '/' . $category->slug);

        rmdir($this->trackManager->getUploadPath() . '/' . $category->slug);

        $this->seeInDatabase('photos', ['imageable_type' => 'Category', 'imageable_id' => $category->id]);

        $photos = \App\Src\Photo\Photo::where('imageable_type', 'Category')->where('imageable_id',
            $category->id)->first();

        $this->fileExists(base_path(public_path() . '/uploads/thumbnail/' . $photos->name));

        unlink(public_path() . '/uploads/thumbnail/' . $photos->name);

        $this->onPage('/admin/category');
    }

}
