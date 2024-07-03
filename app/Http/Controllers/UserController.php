<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    private $userRepo;

    public function __construct(UserRepository $userRepository) {
        $this->userRepo = $userRepository;
    }

    public function index()
    {
        return response()->json([
            'message' => 'User index.',
            'users' => $this->userRepo->all()
        ]);
    }

    public function show(User $user)
    {
        return response()->json([
            'message' => 'Success.',
            'user' => $user->load('posts')
        ]);
    }

    public function update(UpdateUserRequest $req, User $user)
    {
        $user->fill($req->validated());

        $avatar = $req->file('avatar');

        $avatars = glob(public_path('storage/avatars/'.$req->user()->id.'.*'));
        foreach ($avatars as $avatar_path) {
            File::delete($avatar_path);
        }

        if ($avatar) {
            $path = $req->user()->id.'.'.$avatar->getClientOriginalExtension();

            $avatar->storeAs('avatars', $path);

            $user->fill([
                'avatar' => $path
            ]);
        }

        $user->save();

        return response()->json([
            'message'=> 'User updated.',
            'user' => $user
        ], 201);
    }

    public function destroy(User $user)
    {
        if ($user->avatar) {
            $path = public_path('storage/avatars/').$user->avatar;

            if (File::exists($path)) {
                File::delete($path);
            };
        };

        return response()->json([
            'message'=> 'User deleted.',
            'user' => $user->delete()
        ]);
    }

}
