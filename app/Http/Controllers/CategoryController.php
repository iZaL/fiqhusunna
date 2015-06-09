<?php

namespace App\Http\Controllers;

use App\Src\Category\CategoryRepository;
use App\Src\Track\TrackUploader;
use Storage;

class CategoryController extends Controller
{

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */
    public function index()
    {
        return view('modules.book.index');
    }

    public function show($id, TrackUploader $trackUploader)
    {
        dd($trackUploader->getUploadPath());
        dd(Storage::directories($trackUploader->getUploadPath()));
        $category = $this->categoryRepository->model->with('albums')->find($id);

        dd(Storage::allFiles($trackUploader->getUploadPath()));

    }

}
