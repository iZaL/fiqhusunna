<?php
namespace App\Src\Photo;

use App;
use App\Core\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PhotoRepository extends BaseRepository
{

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    public $model;

    public $imageService;

    /**
     * Construct
     *
     * @internal param \Illuminate\Database\Eloquent\Model $user
     * @param Photo $model
     */
    public function __construct(Photo $model)
    {
        $this->model = $model;
    }

    /**
     * Save the entry in Database
     * @param Model $model
     * @param array $array
     * @return bool
     */
    public function create(Model $model, $array = [])
    {

        $photo = $model->photos()->save(new Photo($array));

        return $photo ? true : false;
    }

    /**
     * @param UploadedFile $file
     * @param Model $model
     * @param array $fields
     * @return bool
     * Uploads a photo and then Creates an Entry in the Database
     */
    public function attach(UploadedFile $file, Model $model, $fields = [])
    {
        $upload = $this->uploadFile($file, $model);

        if (!$upload) {
            throw new \Exception('Image Could Not be uploaded to the Server');
        }

        $photo = $this->create($model, array_merge($fields, ['name' => $upload->getHashedName()]));

        if (!$photo) {
            throw new \Exception('Image Record Could No be created in the Database');
        }

        return $this;
    }

    public function uploadFile(UploadedFile $file, Model $model, $array = [])
    {
        $this->setImageService($model);
        // upload the file to the server
        $upload = $this->imageService->store($file);

        return $upload;
    }

    /**
     * @param UploadedFile $file
     * @param Model $model
     * @param array $fields
     * Replace the Existing Thumbnail Photo with the current one
     * @param $imageableID
     * @return bool
     */
    public function replace(UploadedFile $file, Model $model, $fields = [], $imageableID)
    {
        $reflectionModel = new \ReflectionClass($model);
        $photos = $this->model->where('imageable_type',
            $reflectionModel->getShortName())->where('imageable_id', $imageableID)->where('thumbnail', 1)->get();

        // delete the old file
        if (count($photos)) {
            foreach ($photos as $photo) {
                $this->destroy($model, $photo);
            }
        }

        //attach new file
        return $this->attach($file, $model, $fields);
    }


    /**
     * @return mixed
     */
    public function getImageService()
    {
        return $this->imageService;
    }

    /**
     * @param $model
     */
    public function setImageService(Model $model)
    {
        $imageService = App::make('App\\Src\\' . $this->getClassShortName($model) . '\\ImageService');

        $this->imageService = $imageService;
    }

    private function destroy($model, $photo)
    {
        // set the class
        $this->setImageService($model);

        // destroy the file
        $this->imageService->destroy($photo->name);

        //destroy the db file
        $photo->delete();
    }

    public function getClassShortName(Model $model)
    {
        $model = new \ReflectionClass($model);
        $classShortName = $model->getShortName();

        return $classShortName;
    }
}