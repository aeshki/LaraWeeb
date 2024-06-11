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
            'posts' => $this->postRepo
                ->all()
                ->load('author')
        ]);
    }

    public function show(Post $post)
    {
        return response()->json([
            'message' => 'Post show.',
            'post' => $post->load('author')
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
            'post' => $post
        ]);
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $post->update($request->validated());

        return response()->json([
            'message'=> 'Post updated.',
            'post' => $post
        ], 201);
    }

    public function destroy(Post $post)
    {
        return response()->json([
            'message'=> 'Post deleted.',
            'post' => $post->delete()
        ]);
    }

}
