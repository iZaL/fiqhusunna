<?php
namespace App\Src\Track;

use App\Src\Album\AlbumRepository;
use App\Src\Category\CategoryRepository;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class TrackUploader
{

    public $uploadPath;

    /**
     * @var Filesystem
     */
    private $filesystem;
    /**
     * @var TrackRepository
     */
    private $trackRepository;
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;
    /**
     * @var AlbumRepository
     */
    private $albumRepository;

    protected $allowedExtension = ['mp3'];

    public $trackPath;
    /**
     * @param Filesystem $filesystem
     * @param TrackRepository $trackRepository
     * @param CategoryRepository $categoryRepository
     * @param AlbumRepository $albumRepository
     */
    public function __construct(
        Filesystem $filesystem,
        TrackRepository $trackRepository,
        CategoryRepository $categoryRepository,
        AlbumRepository $albumRepository
    ) {
        $this->filesystem = $filesystem;
        $this->trackRepository = $trackRepository;
        $this->categoryRepository = $categoryRepository;
        $this->albumRepository = $albumRepository;
        $this->setUploadPath(public_path().'/tracks');
        $this->setTrackPath('/tracks');
    }

    /**
     * @return mixed
     */
    public function getUploadPath()
    {
        return $this->uploadPath;
    }

    /**
     * @param mixed $uploadPath
     */
    private function setUploadPath($uploadPath)
    {
        $this->uploadPath = $uploadPath;
    }

    /**
     * @param $category directory name
     * @return $this
     */
    public function createCategoryDirectory($category)
    {
        if ($this->filesystem->isDirectory($this->getUploadPath() . '/' . $category)) {
            return;
        }

        try {
            $this->filesystem->makeDirectory($this->getUploadPath() . '/' . $category, '0775');
        } catch (\Exception $e) {
            dd('Cannot Create Directory ' . $category);
        }

        return $this;
    }

    /**
     * @param $category category directory name
     * @param $album album directory name
     * @return $this
     */
    public function createAlbumDirectory($category, $album)
    {
        if ($this->filesystem->isDirectory($this->getUploadPath() . '/' . $category . '/' . $album)) {
            return $this;
        }

        try {
            $this->filesystem->makeDirectory($this->getUploadPath() . '/' . $category . '/' . $album, '0775');
        } catch (\Exception $e) {
            dd('Cannot Create Directory ' . $category . '/' . $album);
        }

        return $this;
    }

    /**
     * Go to all directories
     * Fetch new songs that are not in the DB
     * update the DB with the new data
     */
    public function syncTracks()
    {

        // Get The Folders In the Root of Upload Path( Category )
        $catDirs = $this->filesystem->directories($this->getUploadPath());

        // Loop over through each directory
        foreach ($catDirs as $catDir) {

            // save the new directories into the db
            $catDirName = $this->getDirName($catDir);
            $this->saveCategory($catDirName);

            // get the folders in each category
            // save the new folders (i.e albums ) into the db
            $albums = $this->filesystem->directories($catDir);

            foreach ($albums as $album) {

                $albumDirName = $this->getDirName($album);

                $this->saveAlbum($albumDirName, $catDirName);

            }

            // get all the tracks in the category folder and sub folders and save the new ones into DB
            $this->saveTracks($catDir);

        }

        return $this;
    }

    /**
     * @param $catDirName
     * @return mixed
     */
    public function saveCategory($catDirName)
    {
        $dbCategories = $this->categoryRepository->model->lists('name_ar');
        if (!in_array($catDirName, $dbCategories->toArray())) {
            $this->categoryRepository->model->create([
                'name_ar'        => $catDirName,
                'description_ar' => $catDirName,
            ]);

        }

        return $this;
    }

    /**
     * @param $albumDirName
     * @param $catDirName
     * @return array
     */
    public function saveAlbum($albumDirName, $catDirName)
    {
        $dbAlbums = $this->albumRepository->model->lists('name_ar')->toArray();

        if (!in_array($albumDirName, $dbAlbums)) {

            $category = $this->categoryRepository->model->where('name_ar', $catDirName)->first();

            $this->albumRepository->model->create([
                'name_ar'        => $albumDirName,
                'description_ar' => $albumDirName,
                'category_id'    => $category ? $category->id : '',
            ]);

        }

        return $this;
    }


    /**
     * @param $path
     * @return $this
     */
    public function saveTracks($path)
    {
        // fetch all the tracks in the folder
        $tracks = $this->filesystem->allFiles($path);

        // fetch all the saved tracks in DB
        $dbTracks = $this->trackRepository->model->lists('url')->toArray();

        foreach ($tracks as $track) {
            // Check for valid audio extensions
            if (in_array($track->getExtension(), $this->allowedExtension)) {

                // Check if the Track is not already saved in DB
                if (!in_array($track->getRelativePathName(), $dbTracks)) {
                    $this->trackRepository->model->create([
                        'title_ar'  => $track->getFileName(),
                        'url'       => $track->getRelativePathName(),
                        'size'      => $track->getSize(),
                        'extension' => $track->getExtension(),
                    ]);
                }
            }

        }

        return $this;
    }

    /**
     * @param UploadedFile $file Upload File
     * @param Track $track
     * @param $categorySlug
     * @return string
     */
    public function createCategoryTrack(UploadedFile $file, Track $track, $categorySlug)
    {
        // move $track to category folder
        try {
            $file->move($this->getUploadPath() . '/' . $categorySlug, $track->title);
        } catch (\Exception $e) {
            return 'Error While Moving File. ' . $e->getMessage();
        }
    }

    /**
     * @param UploadedFile $file
     * @param Track $track
     * @param $categorySlug
     * @param $albumSlug
     * @return string
     */
    public function createAlbumTrack(UploadedFile $file, Track $track, $categorySlug, $albumSlug)
    {
        // move $track to category folder
        try {
            $file->move($this->getUploadPath() . '/' . $categorySlug . '/' . $albumSlug, $track->title);
        } catch (\Exception $e) {
            return 'Error While Moving File. ' . $e->getMessage();
        }
    }

    /**
     * Get the Directory Name from Full path
     * @param $directory
     * @return array
     */
    public function getDirName($directory)
    {
        $array = explode('/', $directory);
        $dirName = array_pop($array);

        return $dirName;
    }

    /**
     * @return array
     */
    public function getAllowedExtension()
    {
        return $this->allowedExtension;
    }

    /**
     * @return mixed
     */
    public function getTrackPath()
    {
        return $this->trackPath;
    }

    /**
     * @param mixed $trackPath
     */
    private function setTrackPath($trackPath)
    {
        $this->trackPath = $trackPath;
    }

}