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
        $this->authorize('viewAny', auth()->user());

        return response()->json([
            'message' => 'User index.',
            'users' => User::public()->get()
        ]);
    }

    public function show(User $user)
    {
        $data = $user->is_private && $user->id !== auth()->user()->id
            ? $user->makeHidden([
                    'favorite_anime',
                    'favorite_manga',
                    'favorite_webtoon'
                ])
            :  $user->load('posts.latestComment');

        return response()->json([
            'message' => 'Success.',
            'user' => $data
        ]);
    }

    public function update(UpdateUserRequest $req, User $user)
    {
        $this->authorize('update', $user);

        $user->fill($req->validated());

        $avatar = $req->file('avatar');

        if ($avatar) {
            $avatars = glob(public_path('storage/avatars/'.$req->user()->id.'.*'));
            foreach ($avatars as $avatar_path) {
                File::delete($avatar_path);
            }
            
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
        $this->authorize('delete', $user);

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
