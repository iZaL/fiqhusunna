<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Src\Album\AlbumRepository;
use App\Src\Category\CategoryRepository;
use App\Src\Photo\PhotoRepository;
use App\Src\Track\TrackUploader;
use Illuminate\Http\Request;

class AlbumController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Home Controller
    |--------------------------------------------------------------------------
    |
    | This controller renders your application's "dashboard" for users that
    | are authenticated. Of course, you are free to change or remove the
    | controller as you wish. It is just here to get your app started!
    |
    */
    /**
     * @var AlbumRepository
     */
    private $albumRepository;
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;
    /**
     * @var TrackUploader
     */
    private $trackUploader;

    /**
     * Create a new controller instance.
     * @param AlbumRepository $albumRepository
     * @param CategoryRepository $categoryRepository
     * @param TrackUploader $trackUploader
     */
    public function __construct(
        AlbumRepository $albumRepository,
        CategoryRepository $categoryRepository,
        TrackUploader $trackUploader
    ) {
        $this->albumRepository = $albumRepository;
        $this->categoryRepository = $categoryRepository;
        $this->trackUploader = $trackUploader;
    }


    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */
    public function index()
    {
        $albums = $this->albumRepository->model->with(['category'])->get();

        return view('admin.modules.album.index', compact('albums'));
    }

    public function show($id)
    {
        dd($id);
    }

    public function create()
    {
        $categories = $this->categoryRepository->model->all()
            ->lists('name_ar', 'id');

        return view('admin.modules.album.create', compact('categories'));
    }

    /**
     * @param Request $request
     * @param PhotoRepository $photoRepository
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request, PhotoRepository $photoRepository)
    {
        $this->validate($request, $this->albumRepository->model->rules);

        $album = $this->albumRepository->model->create(array_merge($request->all(),
            ['slug' => str_slug($request->get('name_ar'))]));

        $category = $this->categoryRepository->model->find($request->get('category_id'));

        //create a folder
        $this->trackUploader->createAlbumDirectory($category->slug, $album->slug);

        // upload photos
        if ($request->hasFile('cover')) {
            $photoRepository->attach($request->file('cover'), $album, ['thumbnail' => 1]);
        }

        return redirect('admin/album')->with('message', 'success');
    }

    public function edit($id)
    {
        $album = $this->albumRepository->model->find($id);
        $categories = $this->categoryRepository->model->all()->lists('name_ar', 'id');

        return view('admin.modules.album.edit', compact('album', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, $this->albumRepository->model->rules);

        $album = $this->albumRepository->model->find($id);
        $album->update($request->all());

        return redirect('admin')->with('message', 'success');

    }

    public function destroy($id)
    {
        $category = $this->albumRepository->model->find($id);
        $category->delete();

        return redirect()->back()->with('success', 'Record Deleted');
    }


}
