<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Request;

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

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());

        return response()->json([
            'message'=> 'User updated.',
            'user' => $user
        ], 201);
    }

    public function destroy(User $user)
    {
        return response()->json([
            'message'=> 'User deleted.',
            'user' => $user->delete()
        ]);
    }

}
