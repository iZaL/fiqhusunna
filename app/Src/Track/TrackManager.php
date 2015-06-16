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
    private $relativePath;

    // used only to play files in the site
    private $absolutePath;

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
        $this->setRelativePath(base_path() . '/tracks');
        $this->setAbsolutePath('/tracks');
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
        $this->filesystem->makeDirectory($this->getRelativePath() . '/' . $categorySlug, '0777', true, true);

        return $this;
    }

    /**
     * @param $oldCategorySlug
     * @param string $categorySlug directory name
     * @return $this
     * @throws \Exception
     */
    public function updateCategoryDirectory($oldCategorySlug, $categorySlug)
    {

        if (!$this->filesystem->isDirectory($this->getRelativePath() . '/' . $oldCategorySlug)) {
            throw new \Exception('old directory not found');
        }

        // Rename a Directory
        $this->filesystem->move($this->getRelativePath() . '/' . $oldCategorySlug,
            $this->getRelativePath() . '/' . $categorySlug);

        return $this;
    }


    /**
     * @param string $categorySlug category directory name
     * @param string $albumSlug album directory name
     * @return $this
     * @throws \Exception
     */
    public function createAlbumDirectory($categorySlug, $albumSlug)
    {
        if ($this->filesystem->isDirectory($this->getRelativePath() . '/' . $categorySlug . '/' . $albumSlug)) {
            return;
        }

        $this->filesystem->makeDirectory($this->getRelativePath() . '/' . $categorySlug . '/' . $albumSlug, '0777'
            );

        return $this;
    }

    /**
     * @param string $categorySlug category directory name
     * @param $oldAlbumSlug
     * @param string $albumSlug album directory name
     * @return $this
     * @throws \Exception
     */
    public function updateAlbumDirectory($categorySlug, $oldAlbumSlug, $albumSlug)
    {
        $oldPath = $this->getRelativePath() . '/' . $categorySlug . '/' . $oldAlbumSlug;
        $newPath = $this->getRelativePath() . '/' . $categorySlug . '/' . $albumSlug;

        if (!$this->filesystem->isDirectory($oldPath)) {
            throw new \Exception('old directory not found');
        }

        $this->filesystem->move($oldPath, $newPath);

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
        return $this->getTrack($track, $this->getAbsolutePath());

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
        $file->move($uploadDir, $track->url);

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
     * @return array
     */
    public function getAllowedExtension()
    {
        return $this->allowedExtension;
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
     * get relative track path ( For Frontend)
     * @return mixed
     */
    public function getAbsolutePath()
    {
        return $this->absolutePath;
    }

    /**
     * @param mixed $absolutePath
     */
    private function setAbsolutePath($absolutePath)
    {
        $this->absolutePath = $absolutePath;
    }

}