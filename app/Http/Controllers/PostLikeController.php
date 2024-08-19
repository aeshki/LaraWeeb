<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostLike;

class PostLikeController extends Controller
{
    public function like(Post $post)
    {   
        $this->authorize('update', auth()->user());

        $userId = auth()->id();

        if ($post->is_liked) {
            return response()->json([
                'message' => 'Post already liked.'
            ], 409);
        };
        
        PostLike::create([
            'post_id' => $post->id,
            'user_id' => $userId
        ]);

        return response()->json([
            'message' => 'Post liked successfully.'
        ], 201);
    }

    public function unlike(Post $post)
    {
        $this->authorize('delete', auth()->user());

        $like = $post->likes()->where('user_id', auth()->id())->first();

        if (!$like) {
            return response()->json([
                'message' => 'Like not found'
            ], 404);
        }

        $like->delete();

        return response()->json([
            'message' => 'Like removed successfully.'
        ], 200);
    }
}
