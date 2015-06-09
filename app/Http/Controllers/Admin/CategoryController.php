<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Src\Category\CategoryRepository;
use App\Src\Photo\PhotoRepository;
use App\Src\Track\TrackUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;
    /**
     * @var TrackUploader
     */
    private $trackUploader;

    /**
     * @param CategoryRepository $categoryRepository
     * @param TrackUploader $trackUploader
     */
    public function __construct(CategoryRepository $categoryRepository, TrackUploader $trackUploader)
    {
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
        $categories = $this->categoryRepository->model->all();

        return view('admin.modules.category.index', compact('categories'));
    }

    public function show($id)
    {
        dd($id);
    }

    public function create()
    {
        return view('admin.modules.category.create');
    }

    /**
     * @param Request $request
     * @param Storage $storage
     * @param PhotoRepository $photoRepository
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request, Storage $storage, PhotoRepository $photoRepository)
    {
        $this->validate($request, $this->categoryRepository->model->rules);

        $category = $this->categoryRepository->model->create(array_merge($request->all(),
            ['slug' => str_slug($request->name_ar)]));

        //create a folder
        $this->trackUploader->createCategoryDirectory($category->slug);

        // upload photos
        if ($request->hasFile('cover')) {
            $photoRepository->attach($request->file('cover'), $category, ['thumbnail' => 1]);
        }

        return redirect('/admin/category')->with('message', 'success');
    }

    public function edit($id)
    {
        $category = $this->categoryRepository->model->find($id);


        return view('admin.modules.category.edit', compact('category'));
    }

    public function update(Request $request, PhotoRepository $photoRepository, $id)
    {
        $this->validate($request, ['name_ar' => 'required|unique:categories,name_ar,' . $id]);

        $category = $this->categoryRepository->model->find($id);

        $category->update($request->all());

        if ($request->hasFile('cover')) {
            $photoRepository->replace($request->file('cover'), $category, ['thumbnail' => 1], $id);
        }

        return redirect('admin/category')->with('message', 'success');

    }

    public function destroy($id)
    {
        dd('cat' . $id);
        $category = $this->categoryRepository->model->find($id);
        $category->delete();

        return redirect()->back()->with('success', 'Record Deleted');
    }
}
