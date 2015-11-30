<?php
namespace App\Http\Controllers;

use App\Src\Blog\BlogRepository;
use App\Src\Category\CategoryRepository;
use App\Src\Track\TrackRepository;

class HomeController extends Controller
{

    /**
     * Show the application dashboard to the user.
     *
     * @param TrackRepository $trackRepository
     * @param CategoryRepository $categoryRepository
     * @param BlogRepository $blogRepository
     * @return Response
     */
    public function index(TrackRepository $trackRepository,CategoryRepository $categoryRepository,BlogRepository $blogRepository)
    {
        // Get all Tracks
        $blogCategories = $categoryRepository->model->has('blogs')->get();
        $latestTracks = $trackRepository->model->with('metas')->orderBy('created_at', 'desc')->paginate(10);
        $articles = $blogRepository->model->latest()->paginate(5);
        return view('home', compact('latestTracks','blogCategories','articles'));
    }

}