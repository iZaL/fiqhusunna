<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Src\Album\AlbumRepository;
use App\Src\Category\CategoryRepository;
use App\Src\Photo\PhotoRepository;
use App\Src\Track\TrackManager;
use Illuminate\Http\Request;

class AlbumController extends Controller
{

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
    private $trackManager;

    /**
     * Create a new controller instance.
     * @param AlbumRepository $albumRepository
     * @param CategoryRepository $categoryRepository
     * @param TrackManager $trackUploader
     */
    public function __construct(
        AlbumRepository $albumRepository,
        CategoryRepository $categoryRepository,
        TrackManager $trackUploader
    ) {
        $this->albumRepository = $albumRepository;
        $this->categoryRepository = $categoryRepository;
        $this->trackManager = $trackUploader;
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
        $this->validate($request, [
            'name_ar'     => 'required|unique:albums,name_ar',
            'category_id' => 'required:numeric|not_in:0',
            'cover'       => 'image'
        ]);

        $album = $this->albumRepository->model->fill(array_merge($request->all(),
            ['slug' => $request->get('name_ar')]));

        $category = $this->categoryRepository->model->find($album->category_id);

        //create a folder
        $this->trackManager->createAlbumDirectory($category->slug, $album->slug);

        $album->save();
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

    /**
     * @param Request $request
     * @param PhotoRepository $photoRepository
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, PhotoRepository $photoRepository, $id)
    {
        $this->validate($request, [
            'name_ar'     => 'required|unique:albums,name_ar,' . $id,
            'category_id' => 'required:numeric|not_in:0',
            'cover'       => 'image'
        ]);

        $album = $this->albumRepository->model->find($id);

        $oldAlbumSlug = $album->slug;

        $album->fill(array_merge(['slug' => $request->name_ar], $request->except('cover')));

        if ($request->hasFile('cover')) {
            $photoRepository->replace($request->file('cover'), $album, ['thumbnail' => 1], $id);
        }

        if ($album->isDirty('name_ar')) {
            $this->trackManager->updateAlbumDirectory($album->category->slug, $oldAlbumSlug,
                $album->slug);
        }

        $album->save();

        return redirect('admin/album')->with('message', 'success');

    }

    public function destroy($id)
    {
        $category = $this->albumRepository->model->find($id);
        $category->delete();

        return redirect()->back()->with('success', 'Record Deleted');
    }


}
