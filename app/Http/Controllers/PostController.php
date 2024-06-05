<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
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
            'message' => 'Posts index.',
            'data' => $this->postRepo->all()
        ]);
    }

    public function show(Post $post)
    {
        return response()->json([
            'message' => 'Post show.',
            'data' => $post
        ]);
    }

    public function store(StorePostRequest $req)
    {
        $post = Post::create([
            ...$req->validated(),
            'user_id' => auth()->id()
        ]);

        return response()->json([
            'message' => 'Post created succesfully.',
            'data' => $post
        ]);
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $post->update($request->validated());

        return response()->json([
            'message'=> 'Post updated.',
            'data' => $post
        ], 201);
    }

    public function destroy(Post $post)
    {
        return response()->json([
            'message'=> 'Post deleted.',
            'data' => $post->delete()
        ]);
    }

}
