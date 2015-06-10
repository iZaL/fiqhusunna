<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\App;

class AlbumControllerTest extends TestCase
{

    use DatabaseTransactions;
    use WithoutMiddleware;

    protected $trackUploader;
    protected $user;
    protected $catName;
    protected $albumName;
    protected $category;
    /**
     * @var
     */
    private $faker;

    public function __construct()
    {
        parent::setUp();

        $this->trackUploader = App::make('\App\Src\Track\TrackUploader');
        $user = factory('App\Src\User\User')->make();
        $this->user = $user;
        $this->albumName = 'a b' . uniqid();
        $this->catName = 'a b' . uniqid();

        $this->category = \App\Src\Category\Category::create([
            'name_en'        => $this->catName,
            'name_ar'        => $this->catName,
            'slug'           => str_slug($this->catName),
            'description_ar' => 'description',
            'description_en' => 'description',
        ]);
    }

    public function testStore()
    {
        //
        if (!file_exists($this->trackUploader->getUploadPath() . '/' . $this->category->slug)) {
            mkdir($this->trackUploader->getUploadPath() . '/' . $this->category->slug);
        }
        $this->visit('/admin/album/create')
            ->select($this->category->id, 'category_id')
            ->type($this->albumName, 'name_ar')
            ->type('description', 'description_ar')
            ->attach(public_path() . '/img/product_02.jpg', 'cover')
            ->press('Save');

        $this->seeInDatabase('albums',
            [
                'category_id'    => $this->category->id,
                'name_ar'        => $this->albumName,
                'description_ar' => 'description',
                'slug'           => str_slug($this->albumName)
            ]);

        $album = \App\Src\Album\Album::where('name_ar', $this->albumName)->where('category_id',
            $this->category->id)->first();

        $this->assertFileExists($this->trackUploader->getUploadPath() . '/' . $this->category->slug . '/' . $album->slug);

        rmdir($this->trackUploader->getUploadPath() . '/' . $this->category->slug . '/' . $album->slug);
        rmdir($this->trackUploader->getUploadPath() . '/' . $this->category->slug);

        $this->seeInDatabase('photos', ['imageable_type' => 'Album', 'imageable_id' => $album->id]);

        $photos = \App\Src\Photo\Photo::where('imageable_type', 'Album')->where('imageable_id',
            $album->id)->first();

        $this->fileExists(base_path(public_path() . '/uploads/thumbnail/' . $photos->name));

        unlink(public_path() . '/uploads/thumbnail/' . $photos->name);

        $this->onPage('/admin/album');
    }

}
