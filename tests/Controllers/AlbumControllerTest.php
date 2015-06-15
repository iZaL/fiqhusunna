<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\App;

/**
 * @property  trackManager
 */
class AlbumControllerTest extends TestCase
{

    use DatabaseTransactions;
    use WithoutMiddleware;

    protected $trackManager;
    protected $user;

    /**
     * @var
     */
    private $faker;

    public function setUp()
    {
        parent::setUp();

        $this->trackManager = App::make('\App\Src\Track\TrackManager');
        $this->user = factory('App\Src\User\User', 1)->create(['email' => uniqid() . '@email.com']);

    }

    public function testStore()
    {
        $uniqueName = uniqid();

        $category = factory('App\Src\Category\Category', 1)->create([
            'name_ar' => $uniqueName
        ]);

        $albumName = uniqid();

        if (!file_exists($this->trackManager->getRelativePath() . '/' . $category->slug)) {
            mkdir($this->trackManager->getRelativePath() . '/' . $category->slug);
        }

        $this->actingAs($this->user)
            ->visit('/admin/album/create')
            ->select($category->id, 'category_id')
            ->type($albumName, 'name_ar')
            ->type('description', 'description_ar')
            ->attach(public_path() . '/img/test.jpg', 'cover')
            ->press('Save');

        $this->seeInDatabase('albums',
            [
                'category_id'    => $category->id,
                'name_ar'        => $albumName,
                'description_ar' => 'description',
                'slug'           => str_slug($albumName)
            ]);

        $album = \App\Src\Album\Album::where('name_ar', $albumName)->where('category_id',
            $category->id)->first();

        $this->assertFileExists($this->trackManager->getRelativePath() . '/' . $category->slug . '/' . $album->slug);

        rmdir($this->trackManager->getRelativePath() . '/' . $category->slug . '/' . $album->slug);
        rmdir($this->trackManager->getRelativePath() . '/' . $category->slug);

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
        $albumName = uniqid();
        $catName = uniqid();

        $category = factory('App\Src\Category\Category', 1)->create(['name_ar' => $catName, 'slug' => $catName]);
        $oldAlbum = factory('App\Src\Album\Album', 1)->create([
            'name_ar'     => $albumName,
            'category_id' => $category->id,
            'slug'        => $albumName
        ]);

        if (!file_exists($this->trackManager->getRelativePath() . '/' . $category->slug)) {
            mkdir($this->trackManager->getRelativePath() . '/' . $category->slug);
        }

        if (!file_exists($this->trackManager->getRelativePath() . '/' . $category->slug . '/' . $oldAlbum->slug)) {
            mkdir($this->trackManager->getRelativePath() . '/' . $category->slug . '/' . $oldAlbum->slug);
        }

        $updateName = uniqid();

        $this->visit('/admin/album/'.$oldAlbum->id.'/edit/')
            ->select($category->id, 'category_id')
            ->type($updateName, 'name_ar')
            ->type('description', 'description_ar')
            ->attach(public_path() . '/img/test.jpg', 'cover')
            ->press('Save');

        $this->seeInDatabase('albums',
            [
                'category_id'    => $category->id,
                'name_ar'        => $updateName,
                'description_ar' => 'description',
                'slug'           => $updateName
            ]);

        $album = \App\Src\Album\Album::where('name_ar', $updateName)->where('category_id',
            $category->id)->first();

        $this->assertFileNotExists($this->trackManager->getRelativePath() . '/' . $category->slug . '/' . $oldAlbum->slug);

        $this->assertFileExists($this->trackManager->getRelativePath() . '/' . $category->slug . '/' . $album->slug);

        rmdir($this->trackManager->getRelativePath() . '/' . $category->slug . '/' . $album->slug);

        rmdir($this->trackManager->getRelativePath() . '/' . $category->slug);

        $this->onPage('/admin/album');
    }


}
