<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Src\Photo\ImageService;
use App\Src\Photo\PhotoRepository;

class PhotoController extends Controller
{

    private $photoRepository;

    private $imageService;

    /**
     * @param PhotoRepository $photoRepository
     * @param ImageService $imageService
     */
    function __construct(PhotoRepository $photoRepository, ImageService $imageService)
    {
        $this->photoRepository = $photoRepository;
        $this->imageService = $imageService;
    }

    /**
     * @param $id Photo ID
     * @return \Illuminate\Http\RedirectResponse
     *
     */
    public function destroy($id)
    {
        $photo = $this->photoRepository->model->find($id);
        if ($photo->delete()) {

            $this->imageService->destroy($photo->name);

            return redirect()->back()->with('success', 'Photo Deleted');
        }

        return redirect()->back()->with('error', 'Error: Photo Not Found');
    }

}
