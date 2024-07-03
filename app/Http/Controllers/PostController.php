<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function index()
    {
        return response()->json([
            'message' => 'Posts index.',
            'posts' => Post::all()->load([ 'author', 'latestComment' ])
        ]);
    }

    public function show(Post $post)
    {
        return response()->json([
            'message' => 'Post show.',
            'post' => $post->load([ 'author', 'comments', 'latestComment' ])
        ]);
    }

    public function store(StorePostRequest $req)
    {
        DB::beginTransaction();

        $post = Post::create([
            ...$req->validated(),
            'user_id' => auth()->id()
        ]);

        $image = $req->file('image');

        if ($image) {
            $path = $post->id.'.'.$image->getClientOriginalExtension();

            $image->storeAs('posts', $path);

            $post->update([
                'image' => $path
            ]);
        }

        DB::commit();

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
        if ($post->image) {
            $path = public_path('storage/posts/').$post->image;

            if (File::exists($path)) {
                File::delete($path);
            };
        };

        return response()->json([
            'message'=> 'Post deleted.',
            'post' => $post->delete()
        ]);
    }
}
