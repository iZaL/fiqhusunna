<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Src\Album\AlbumRepository;
use App\Src\Category\CategoryRepository;
use App\Src\Track\TrackRepository;
use App\Src\Track\TrackUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class TrackController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Home Controller
    |--------------------------------------------------------------------------
    |
    | This controller renders your application's "dashboard" for users that
    | are authenticated. Of course, you are free to change or remove the
    | controller as you wish. It is just here to get your app started!
    |
    */
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

    private $trackUploader;


    /**
     * Create a new controller instance.
     * @param TrackRepository $trackRepository
     * @param CategoryRepository $categoryRepository
     * @param AlbumRepository $albumRepository
     * @param TrackUploader $trackUploader
     */
    public function __construct(
        TrackRepository $trackRepository,
        CategoryRepository $categoryRepository,
        AlbumRepository $albumRepository,
        TrackUploader $trackUploader
    ) {
        $this->trackRepository = $trackRepository;
        $this->categoryRepository = $categoryRepository;
        $this->albumRepository = $albumRepository;
        $this->trackUploader = $trackUploader;
    }

    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */
    public function index()
    {
        $tracks = $this->trackRepository->model->all();

        $track = $tracks->first();

        return view('admin.modules.track.index', compact('tracks'));
    }

    public function  show($id)
    {
        dd($id);
    }

    public function create(Request $request)
    {
        $type = $request->get('type');
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

        return view('admin.modules.track.create', compact('trackeables', 'type'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        // get each tracks from request params
        // upload it
        // and set the titles

        $files = $request->file('tracks');
//        $file = $request->file('tracks');

        $this->validate($request, ['trackeable_id' => 'required|integer']);

        foreach ($files as $file) {

            $track = $this->trackRepository->model->create(array_merge([
                'user_id'         => 1,
                'trackeable_id'   => $request->trackeable_id,
                'trackeable_type' => $request->trackeable_type,
                'title_ar'        => $file->getClientOriginalName(),
                'slug'            => str_slug($file->getClientOriginalName()),
                'url'             => str_slug($file->getClientOriginalName()),
                'extension'       => $file->getClientOriginalExtension(),
                'size'            => $file->getClientSize(),
            ], $request->except('tracks')));

            // move uploaded file
            switch ($request->trackeable_type) {
                case 'category':
                    $this->trackUploader->createCategoryTrack($file, $track, $track->trackeable->slug);
                    break;
                case 'album':
                    $this->trackUploader->createAlbumTrack($file, $track, $track->trackeable->category->slug,
                        $track->trackeable->slug);
                    break;
                default:
                    break;
            }

        }

        return redirect('admin/track')->with('message', 'success');
    }

    public function edit($id)
    {
        $track = $this->trackRepository->model->find($id);
        $type = '';

        if (class_basename($track->trackeable_type) == 'Category') {
            $type = 'Category';
            $trackeables = $this->categoryRepository->model->all()->lists('name_ar', 'id');
        } else {
            $type = 'Album';
            $trackeables = $this->albumRepository->model->all()->lists('name_ar', 'id');
        }

        return view('admin.modules.track.edit', compact('track', 'trackeables', 'type'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, $this->trackRepository->model->rules);

        $track = $this->trackRepository->model->find($id);
        $track->update($request->all());

        return redirect('admin/track')->with('message', 'success');
    }

    public function destroy($id)
    {
        $track = $this->trackRepository->model->find($id);
        unlink(storage_path() . '/app/tracks/' . $track->url);
        $track->delete();

        return redirect()->back()->with('success', 'Record Deleted');
    }

    public function uploadTrack(Request $request)
    {
        return 'true';
        dd($request->all());
    }

}
