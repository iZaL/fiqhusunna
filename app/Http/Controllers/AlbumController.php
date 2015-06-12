<?php

namespace App\Http\Controllers;

use App\Src\Album\AlbumRepository;

class AlbumController extends Controller
{
    /**
     * @var AlbumRepository
     */
    private $albumRepository;

    /**
     * @param AlbumRepository $albumRepository
     */
    public function __construct(AlbumRepository $albumRepository)
    {

        $this->albumRepository = $albumRepository;
    }

    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */
    public function index()
    {
        return view('admin.home');
    }

    public function show($id)
    {
        $album = $this->albumRepository->model->with('tracks')->find($id);
        $album->increment('views');
        $album->save();
        return view('modules.album.view', compact('album'));
    }

}
