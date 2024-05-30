<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\UpdatePostRequest;
use App\Repositories\PostRepository;

class PostController extends Controller
{
    private $postRepo;

    public function __construct(PostRepository $postRepo) {
        $this->postRepo = $postRepo;
    }

    public function index()
    {
        return response()->json([
            'ok' => true,
            'message' => 'Posts index.',
            'data' => $this->postRepo->all()
        ]);
    }

    public function show(Post $post)
    {
        return response()->json([
            'ok' => true,
            'message' => 'Post show.',
            'data' => $post
        ]);
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $post->update($request->validated());

        return response()->json([
            'ok' => true,
            'message'=> 'Post updated.',
            'data' => $post
        ], 201);
    }

    public function destroy(Post $post)
    {
        return response()->json([
            'ok' => true,
            'message'=> 'Post deleted.',
            'data' => $post->delete()
        ]);
    }

}
