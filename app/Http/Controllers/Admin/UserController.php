<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Src\User\UserRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {

        $this->userRepository = $userRepository;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $currentUser = Auth::user();

        $users = $this->userRepository->model->paginate(100);

        return view('admin.modules.user.index', compact('users', 'currentUser'));
    }

    public function edit($id)
    {
        $currentUser = Auth::user();

        $user = $this->userRepository->model->find($id);

        return view('admin.modules.user.edit', compact('user', 'currentUser'));
    }

    public function update(Request $request, $id)
    {
        $currentUser = Auth::user();

        $user = $this->userRepository->model->find($id);

        if (($request->isAdmin == 0) && ($currentUser->id == $user->id)) {
            return redirect()->back()->with('warning', 'You Cannot Un Admin Yourself');
        }

        $user->update($request->all());

        return redirect()->to('/admin/user');
    }

    public function destroy($id)
    {
        $currentUser = Auth::user();

        $user = $this->userRepository->model->find($id);

        if (($currentUser->id == $user->id)) {
            return redirect()->back()->with('warning', 'You Cannot Delete Yourself');
        }

        $user->delete();

        return redirect()->to('/admin/user')->with('success', 'User Deleted');

    }
}
