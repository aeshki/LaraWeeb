<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
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

        $banner = $req->file('banner');

        if ($banner) {
            $banners = glob(public_path('storage/banners/'.$req->user()->id.'.*'));
            foreach ($banners as $banner_path) {
                File::delete($banner_path);
            }
            
            $path = $req->user()->id.'.'.$banner->getClientOriginalExtension();

            $banner->storeAs('banners', $path);

            $user->fill([
                'banner' => $path
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
