<?php
namespace App\Src\Track;

use App\Src\Album\Album;
use App\Src\Track\Track;
use App\Src\Category\Category;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Debug\Exception\ClassNotFoundException;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class TrackManager
{

    // mostly used to download files
    public $relativePath;

    // used only to play files in the site
    public $publicPath;

    private $allowedExtension = ['mp3'];

    private $filesystem;

    private $trackRepository;

    /**
     * @param Filesystem $filesystem
     * @param TrackRepository $trackRepository
     */
    public function __construct(
        Filesystem $filesystem,
        TrackRepository $trackRepository
    ) {
        $this->filesystem = $filesystem;
        $this->trackRepository = $trackRepository;
        $this->setRelativePath(public_path() . '/tracks');
        $this->setPublicPath('/tracks');
    }

    /**
     * @param string $categorySlug directory name
     * @return $this
     */
    public function createCategoryDirectory($categorySlug)
    {
        if ($this->filesystem->isDirectory($this->getRelativePath() . '/' . $categorySlug)) {
            return;
        }

        // Create a Directory
        try {
            $this->filesystem->makeDirectory($this->getRelativePath() . '/' . $categorySlug, '0775');
        } catch (\Exception $e) {
            dd('Cannot Create Directory ' . $categorySlug);
        }

        return $this;
    }

    /**
     * @param string $categorySlug category directory name
     * @param string $albumSlug album directory name
     * @return $this
     */
    public function createAlbumDirectory($categorySlug, $albumSlug)
    {
        if ($this->filesystem->isDirectory($this->getRelativePath() . '/' . $categorySlug . '/' . $albumSlug)) {
            return $this;
        }

        try {
            $this->filesystem->makeDirectory($this->getRelativePath() . '/' . $categorySlug . '/' . $albumSlug, '0775');
        } catch (\Exception $e) {
            dd('Cannot Create Directory ' . $categorySlug . '/' . $albumSlug);
        }

        return $this;
    }

    /**
     * @param \App\Src\Track\Track $track
     * @param $pathType
     * @return string
     * @throws \Exception
     */
    private function getTrack(Track $track, $pathType)
    {
        // If the Track's Type is Category
        // Search In Category Folder
        if (is_a($track->trackeable, Category::class)) {

            $file = $pathType . '/' . $track->trackeable->slug . '/' . $track->url;

        } elseif (is_a($track->trackeable, Album::class)) {

            $file = $pathType . '/' . $track->trackeable->category->slug . '/' . $track->trackeable->slug . '/' . $track->url;

            // or Search In Album Folder
        } else {

            throw new ClassNotFoundException('Invalid Class');
        }

        if (!file_exists($file)) {
            throw new FileNotFoundException('File ' . $track->name . ' Does Not Exist');
        }

        return $file;
    }

    /**
     * Get Public Path of Track to Play
     * @param $track
     * @return string
     * @throws \Exception
     */
    public function fetchTrack(Track $track)
    {
        return $this->getTrack($track, $this->getPublicPath());

    }

    /**
     * Get Relative Path of Track to Download
     * @param \App\Src\Track\Track $track
     * @return string
     * @throws \Exception
     */
    public function downloadTrack(Track $track)
    {
        return $this->getTrack($track, $this->getRelativePath());
    }

    /**
     * @param UploadedFile $file Upload File
     * @param Track $track
     * @return string
     * @throws \Exception
     */
    public function uploadTrack(UploadedFile $file, Track $track)
    {
        // move $track to category folder
        $uploadDir = $this->getRelativePath() . '/';

        // check for Valid Category/Album Types
        if (is_a($track->trackeable, Category::class)) {

            // make sure the category directory exists
            $categorySlug = $track->trackeable->slug;
            $this->createCategoryDirectory($categorySlug);

            $uploadDir .= $categorySlug;

        } elseif (is_a($track->trackeable, Album::class)) {

            $categorySlug = $track->trackeable->category->slug;
            $albumSlug = $track->trackeable->slug;

            $this->createCategoryDirectory($categorySlug);
            $this->createAlbumDirectory($categorySlug, $albumSlug);

            $uploadDir .= $categorySlug . '/' . $albumSlug;

        } else {

            throw new ClassNotFoundException('Invalid Class');
        }

        // Move Uploaded File
        try {
            $file->move($uploadDir, $track->url);
        } catch (\Exception $e) {
            return 'Error While Moving File. ' . $e->getMessage();
        }

        return $this;
    }

    /**
     * Get the Directory Name from Full path
     * @param string $directory
     * @return array
     */
    public function getDirName($directory)
    {
        $array = explode('/', $directory);
        $dirName = array_pop($array);

        return $dirName;
    }

    /**
     * @return mixed
     */
    public function getRelativePath()
    {
        return $this->relativePath;
    }

    /**
     * @param mixed $relativePath
     */
    private function setRelativePath($relativePath)
    {
        $this->relativePath = $relativePath;
    }

    /**
     * @return array
     */
    public function getAllowedExtension()
    {
        return $this->allowedExtension;
    }

    /**
     * get relative track path ( For Frontend)
     * @return mixed
     */
    public function getPublicPath()
    {
        return $this->publicPath;
    }

    /**
     * @param mixed $publicPath
     */
    private function setPublicPath($publicPath)
    {
        $this->publicPath = $publicPath;
    }

    /**
     * Get the Clean Name For Track (Strip Extensions, and Secure)
     * @param $getClientOriginalName
     * @return string
     */
    public function setTrackName($getClientOriginalName)
    {
        $temp = explode('.', $getClientOriginalName);
        $ext = array_pop($temp);
        $name = implode('.', $temp);

        return strip_tags(e($name));
    }

    /**
     * @param $getClientOriginalName
     * @return string
     */
    public function setTrackSlug($getClientOriginalName)
    {
        return str_slug($getClientOriginalName);
    }

}