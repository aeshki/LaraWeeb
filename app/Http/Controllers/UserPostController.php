<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserPostController extends Controller
{
    public function index(User $user)
    {
        if ($user->is_private && $user->id != Auth::id() && !Auth::user()->is_super_admin) {
            abort(404, 'Not Found');
        };

        return response()->json([
            'message' => 'Success',
            'posts' => $user->posts()->with('author')->orderByDesc('created_at')->simplePaginate(25)
        ]);
    }
}
