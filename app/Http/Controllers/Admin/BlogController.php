<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateBlogPostRequest;
use App\Jobs\CreateBlogPost;
use App\Src\Blog\BlogRepository;
use App\Src\Photo\PhotoRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{

    /**
     * @var CategoryRepository
     */
    private $blogRepository;

    /**
     * @param BlogRepository $blogRepository
     */
    public function __construct(BlogRepository $blogRepository)
    {
        $this->blogRepository = $blogRepository;
    }

    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */
    public function index()
    {
        $blogs = $this->blogRepository->model->all();

        return view('admin.modules.blog.index', compact('blogs'));
    }

    public function show($id)
    {
        $blog = $this->blogRepository->model->with('photos')->find($id);

        return view('admin.modules.blog.view', compact('blog'));
    }

    public function create()
    {
        return view('admin.modules.blog.create');
    }

    public function store(Request $request, PhotoRepository $photoRepository)
    {

        $this->validate($request, [
            'title_ar'       => 'required',
            'description_ar' => 'required',
//            'cover'          => 'image'
        ]);

        $blog = $this->blogRepository->model->create([
            'title_ar'       => $request->title_ar,
            'description_ar' => $request->description_ar,
            'user_id'        => Auth::user()->id,
            'slug'           => $request->title_ar
        ]);

        if ($request->hasFile('cover')) {
            $file = $request->file('cover');

            $photoRepository->attach($file, $blog, ['thumbnail' => 1]);
        }

        return redirect('admin/blog')->with('message', 'success');
    }

    public function edit($id)
    {
        $blog = $this->blogRepository->model->with('photos')->find($id);

        return view('admin.modules.blog.edit', compact('blog'));
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
            'title_ar'       => 'required',
            'description_ar' => 'required',
//            'cover'          => 'image'
        ]);

        $blog = $this->blogRepository->model->find($id);

        $blog->update(array_merge(['slug' => $request->title_ar], $request->except('cover')));

        if ($request->hasFile('cover')) {
            $file = $request->file('cover');
            $photoRepository->replace($file, $blog, ['thumbnail' => 1], $id);
        }

        return redirect('admin/blog')->with('message', 'success');

    }

    public function destroy($id)
    {
        $blog = $this->blogRepository->model->find($id);
        $blog->delete();

        return redirect()->back()->with('success', 'Record Deleted');
    }
}
