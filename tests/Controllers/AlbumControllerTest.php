<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\App;

class AlbumControllerTest extends TestCase
{

    use DatabaseTransactions;
    use WithoutMiddleware;

    protected $trackManager;
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

        $this->trackManager = App::make('\App\Src\Track\TrackManager');
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
        if (!file_exists($this->trackManager->getRelativePath() . '/' . $this->category->slug)) {
            mkdir($this->trackManager->getRelativePath() . '/' . $this->category->slug);
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

        $this->assertFileExists($this->trackManager->getRelativePath() . '/' . $this->category->slug . '/' . $album->slug);

        rmdir($this->trackManager->getRelativePath() . '/' . $this->category->slug . '/' . $album->slug);
        rmdir($this->trackManager->getRelativePath() . '/' . $this->category->slug);

        $this->seeInDatabase('photos', ['imageable_type' => 'Album', 'imageable_id' => $album->id]);

        $photos = \App\Src\Photo\Photo::where('imageable_type', 'Album')->where('imageable_id',
            $album->id)->first();

        $this->fileExists(base_path(public_path() . '/uploads/thumbnail/' . $photos->name));

        unlink(public_path() . '/uploads/thumbnail/' . $photos->name);

        $this->onPage('/admin/album');
    }


    public function testUpdate()
    {
        //
        $album = \App\Src\Album\Album::create([
            'name_en'        => uniqid(),
            'name_ar'        => uniqid(),
            'slug'           => uniqid(),
            'description_ar' => 'description',
            'description_en' => 'description',
        ]);

        if (!file_exists($this->trackManager->getRelativePath() . '/' . $this->category->slug)) {
            mkdir($this->trackManager->getRelativePath() . '/' . $this->category->slug);
        }

        $updateName = uniqid();
        $this->visit('/admin/album/edit/'.$album->id)
            ->select($this->category->id, 'category_id')
            ->type($updateName, 'name_ar')
            ->type('description', 'description_ar')
            ->attach(public_path() . '/img/product_02.jpg', 'cover')
            ->press('Save');

        $this->seeInDatabase('albums',
            [
                'category_id'    => $this->category->id,
                'name_ar'        => $updateName,
                'description_ar' => 'description',
                'slug'           => str_slug($updateName)
            ]);

        $album = \App\Src\Album\Album::where('name_ar', $updateName)->where('category_id',
            $this->category->id)->first();

        $this->assertFileExists($this->trackManager->getRelativePath() . '/' . $this->category->slug . '/' . $album->slug);

        rmdir($this->trackManager->getRelativePath() . '/' . $this->category->slug . '/' . $album->slug);
        rmdir($this->trackManager->getRelativePath() . '/' . $this->category->slug);

        $this->seeInDatabase('photos', ['imageable_type' => 'Album', 'imageable_id' => $album->id]);

        $photos = \App\Src\Photo\Photo::where('imageable_type', 'Album')->where('imageable_id',
            $album->id)->first();

        $this->fileExists(base_path(public_path() . '/uploads/thumbnail/' . $photos->name));

        unlink(public_path() . '/uploads/thumbnail/' . $photos->name);

        $this->onPage('/admin/album');
    }

}
