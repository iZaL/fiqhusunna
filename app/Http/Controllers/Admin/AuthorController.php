<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Src\Author\AuthorRepository;
use App\Src\Photo\PhotoRepository;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * @var AuthorRepository
     */
    private $authorRepository;

    /**
     * @param AuthorRepository $authorRepository
     */
    public function __construct(AuthorRepository $authorRepository)
    {
        $this->authorRepository = $authorRepository;
    }

    public function index()
    {
        $authors = $this->authorRepository->model->all();

        return view('admin.modules.author.index', compact('authors'));
    }

    public function show($id)
    {
        dd($this->authorRepository->model->find($id)->toArray());
    }

    public function create()
    {
        return view('admin.modules.author.create');
    }

    /**
     * @param Request $request
     * @param PhotoRepository $photoRepository
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request, PhotoRepository $photoRepository)
    {
        $this->validate($request, [
            'name_ar'     => 'required|unique:authors,name_ar',
            'cover'       => 'image'
        ]);

        $author = $this->authorRepository->model->fill(array_merge($request->except(['cover']),
            ['slug' => $request->get('name_ar')]));

        $author->save();
        // upload photos
        if ($request->hasFile('cover')) {
            $photoRepository->attach($request->file('cover'), $author, ['thumbnail' => 1]);
        }

        return redirect('admin/author')->with('message', 'success');
    }

    public function edit($id)
    {
        $author = $this->authorRepository->model->find($id);

        return view('admin.modules.author.edit', compact('author'));
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
            'name_ar' => 'required|unique:authors,name_ar,' . $id,
            'cover'   => 'image'
        ]);

        $author = $this->authorRepository->model->find($id);

//        $oldAuthorSlug = $author->slug;

        $author->fill(array_merge(['slug' => $request->name_ar], $request->except('cover')));

        if ($request->hasFile('cover')) {
            $photoRepository->replace($request->file('cover'), $author, ['thumbnail' => 1], $id);
        }

        $author->save();

        return redirect('admin/author')->with('message', 'success');

    }

    public function destroy($id)
    {
        $author = $this->authorRepository->model->find($id);
        $author->delete();

        return redirect()->back()->with('success', 'Record Deleted');
    }

}