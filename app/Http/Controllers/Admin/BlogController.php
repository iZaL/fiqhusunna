<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateBlogPostRequest;
use App\Jobs\CreateBlogPost;
use App\Src\Blog\BlogRepository;
use App\Src\Photo\PhotoRepository;

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
        return view('admin.modules.blog.index',compact('blogs'));
    }

    public function show($id)
    {
        $blog = $this->blogRepository->model->with('photos')->find($id);

        return view('admin.modules.blog.view',compact('blog'));
    }

    public function create()
    {
        return view('admin.modules.blog.create');
    }

    public function store(CreateBlogPostRequest $request)
    {
        $job = (new CreateBlogPost($request));
        $this->dispatch($job);

        return redirect('admin/blog')->with('message', 'success');
    }

    public function edit($id)
    {
        $blog = $this->blogRepository->model->with('photos')->find($id);

        return view('admin.modules.blog.edit',compact('blog'));
    }

    /**
     * @param CreateBlogPostRequest $request
     * @param PhotoRepository $photoRepository
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CreateBlogPostRequest $request, PhotoRepository $photoRepository, $id)
    {
        $blog = $this->blogRepository->model->find($id);

        $blog->update($request->all());

        if ($request->hasFile('cover')) {
            $file = $this->request->file('cover');

            $photoRepository->replace($file, $blog, ['thumbnail' => 1]);
        }

        return redirect('admin/blog')->with('message', 'success');

    }

    public function destroy($id)
    {

    }
}
