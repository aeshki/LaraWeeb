<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserPostController extends Controller
{
    public function index(User $user)
    {
        return response()->json([
            'message' => 'Success',
            'posts' => $user->posts
        ]);
    }
}
