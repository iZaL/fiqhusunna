<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadTrackRequest;
use App\Jobs\UploadTrack;
use App\Src\Album\AlbumRepository;
use App\Src\Author\AuthorRepository;
use App\Src\Category\CategoryRepository;
use App\Src\Track\TrackRepository;
use App\Src\Track\TrackUploader;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TrackController extends Controller
{

    /**
     * @var TrackRepository
     */
    private $trackRepository;
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;
    /**
     * @var AlbumRepository
     */
    private $albumRepository;
    /**
     * @var AuthorRepository
     */
    private $authorRepository;

    /**
     * Create a new controller instance.
     * @param TrackRepository $trackRepository
     * @param CategoryRepository $categoryRepository
     * @param AlbumRepository $albumRepository
     * @param AuthorRepository $authorRepository
     */
    public function __construct(
        TrackRepository $trackRepository,
        CategoryRepository $categoryRepository,
        AlbumRepository $albumRepository,
        AuthorRepository $authorRepository
    ) {
        $this->trackRepository = $trackRepository;
        $this->categoryRepository = $categoryRepository;
        $this->albumRepository = $albumRepository;
        $this->authorRepository = $authorRepository;
    }

    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */
    public function index()
    {
        $tracks = $this->trackRepository->model->with(['author'])->paginate(100);

        $today = old('created_at') ? old('created_at')  : Carbon::now()->format('m/d/Y');

        $tracks->load('trackeable');

        return view('admin.modules.track.index', compact('tracks'));
    }

    public function show($id)
    {
        dd($this->trackRepository->model->find($id)->toArray());
    }

    public function create(Request $request)
    {
        $type = $request->get('type');

        $authors = $this->authorRepository->model->all()->lists('name_ar','id');

        $today = old('created_at') ? old('created_at')  : Carbon::now()->format('m/d/Y');


        $authors->prepend('Choose author');

        // Check if The type GET PARAM is valid
        if (!isset($type) || !array_key_exists($type, $this->trackRepository->model->types)) {
            return redirect('admin/track')->with('warning', 'incorrect access');
        }

        switch ($type) {
            case 'category':
                $repository = $this->categoryRepository;
                break;
            case 'album':
                $repository = $this->albumRepository;
                break;
            default :
                $type = 'category';
                $repository = $this->categoryRepository;
                break;
        }

        $trackeables = $repository->model->all()->lists('name_ar', 'id');

        return view('admin.modules.track.create', compact('trackeables', 'type','authors','today'));
    }

    /**
     * @param UploadTrackRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(UploadTrackRequest $request)
    {
        $job = (new UploadTrack($request));
        $this->dispatch($job);

        return redirect('admin/track')->with('message', 'success');
    }

    public function destroy($id)
    {
        $track = $this->trackRepository->model->find($id);
        $trackUrl = storage_path() . '/app/tracks/' . $track->url;
        if(file_exists($trackUrl))
        unlink($trackUrl);
        $track->delete();

        return redirect()->back()->with('success', 'Record Deleted');
    }

}
