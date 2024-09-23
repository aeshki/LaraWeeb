<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\PostLikeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserPostController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function() {
    Route::apiResources([
        'users' => UserController::class,
        'posts' => PostController::class,
        'comments' => CommentController::class
    ]);

    Route::resource('users.posts', UserPostController::class);
    Route::resource('posts.comments', PostCommentController::class);
    
    Route::post('posts/{post}/like', [PostLikeController::class, 'like']);
    Route::delete('posts/{post}/like', [PostLikeController::class, 'unlike']);
});