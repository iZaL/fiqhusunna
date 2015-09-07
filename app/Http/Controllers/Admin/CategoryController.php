<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Src\Category\CategoryRepository;
use App\Src\Photo\PhotoRepository;
use App\Src\Track\TrackManager;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;
    /**
     * @var TrackUploader
     */
    private $trackManager;

    /**
     * @param CategoryRepository $categoryRepository
     * @param TrackManager $trackManager
     */
    public function __construct(CategoryRepository $categoryRepository, TrackManager $trackManager)
    {
        $this->categoryRepository = $categoryRepository;
        $this->trackManager = $trackManager;
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
     * @param PhotoRepository $photoRepository
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request, PhotoRepository $photoRepository)
    {
        $this->validate($request, [
            'name_ar' => 'required|unique:categories,name_ar',
            'cover'   => 'image'
        ]);

        $category = $this->categoryRepository->model->fill(array_merge($request->all(),
            ['slug' => $request->name_ar]));

        //create a folder
        $this->trackManager->createCategoryDirectory($category->slug);

        $category->save();

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
        $this->validate($request, [
            'name_ar' => 'required|unique:categories,name_ar,' . $id,
            'cover'   => 'image'
        ]);

        $category = $this->categoryRepository->model->find($id);

        $oldSlug = $category->slug;

        $category->fill(array_merge($request->all(),
            ['slug' => $request->name_ar]));

        if ($category->isDirty('name_ar')) {

            $this->trackManager->updateCategoryDirectory($oldSlug, $category->slug);

        }

        if ($request->hasFile('cover')) {

            $photoRepository->replace($request->file('cover'), $category, ['thumbnail' => 1], $id);

        }

        $category->save();

        return redirect('admin/category')->with('message', 'success');

    }

    public function destroy($id)
    {
        $category = $this->categoryRepository->model->find($id);
        $category->delete();

        return redirect()->back()->with('success', 'Record Deleted');
    }
}
