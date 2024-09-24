<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostCommentController extends Controller
{
    public function index(Post $post)
    {
        if (!Auth::user()->is_super_admin && $post->author->is_private && (Auth::id() !== $post->author->id)) {
            abort(404, 'Not Found');
        };

        return response()->json([
            'message' => 'Success',
            'comments' => $post->comments()->simplePaginate(25)
        ]);
    }
}