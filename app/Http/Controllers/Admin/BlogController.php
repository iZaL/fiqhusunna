<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateBlogPostRequest;
use App\Jobs\CreateBlogPost;
use App\Src\Blog\BlogRepository;

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
        $blogs = $this->blogRepository->model->with('photos')->find($id);

        return view('admin.modules.blog.view',compact('blogs'));
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

    }

    public function update($id)
    {

    }

    public function destroy($id)
    {

    }
}
