<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ImageManager;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    use ImageManager;

    public function index(Request $request)
    {
        $perPage = 50;
    
        if ($request->has('username')) {
            $username = $request->query('username');

            $users = User::where('username', 'like', $username . '%')
                ->simplePaginate($perPage);
        } else {
            $users = User::simplePaginate($perPage);
        }
    
        return response()->json([
            'message' => 'Users index.',
            'users' => $users
        ]);
    }

    public function show(User $user)
    {
        $data = $user->is_private && $user->id !== Auth::user()->id
            ? $user->makeHidden([
                    'favorite_anime',
                    'favorite_manga',
                    'favorite_webtoon'
                ])
            :  $user;

        return response()->json([
            'message' => 'Success.',
            'user' => $data
        ]);
    }

    public function update(UpdateUserRequest $req, User $user)
    {
        $this->authorize('update', $user);

        $user->fill($req->validated());

        $avatarFile = $req->file('avatar');

        if ($avatarFile) {
            $user->avatar = $this->saveImage($avatarFile, $req->user()->id, 'avatars');
        }

        $bannerFile = $req->file('banner');

        if ($bannerFile) {
            $user->banner = $this->saveImage($bannerFile, $req->user()->id, 'banners');
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
            $this->removeImage("avatars/".$user->avatar);
        };

        if ($user->banner) {
            $this->removeImage("avatars/".$user->banner);
        };

        return response()->json([
            'message'=> 'User deleted.',
            'user' => $user->delete()
        ]);
    }
}
