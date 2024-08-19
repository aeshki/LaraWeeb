<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;

use App\Models\Comment;
use App\Models\Post;

class CommentController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', auth()->user());

        return response()->json([
            'message' => 'Comments index.',
            'posts' => Comment::all()
        ]);
    }

    public function show(Comment $comment)
    {
        $this->authorize('view', $comment);

        return response()->json([
            'message' => 'Comment show.',
            'post' => $comment->load('author')
        ]);
    }

    public function store(StoreCommentRequest $req)
    {
        if (!Post::find($req->post_id)) {
            return response()->json([
                'error' => 'Post not found.'
            ], 404);
        }

        $comment = Comment::create([
            ...$req->validated(),
            'user_id' => auth()->id(),
        ]);

        return response()->json([
            'message' => 'Comment created succesfully.',
            'comment' => $comment->load('author')
        ]);
    }

    public function update(UpdateCommentRequest $req, Comment $comment)
    {
        $this->authorize('update', $comment);

        $comment->update($req->validated());

        return response()->json([
            'message'=> 'Comment updated.',
            'post' => $comment
        ], 201);
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        return response()->json([
            'message'=> 'Comment deleted.',
            'post' => $comment->delete()
        ]);
    }
}