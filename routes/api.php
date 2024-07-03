<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserPostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::middleware('auth:sanctum')->group(function() {
    Route::apiResources([
        'users' => UserController::class,
        'posts' => PostController::class,
        'comments' => CommentController::class
    ]);

    Route::resource('users.posts', UserPostController::class);
    
    Route::get('/user', function (Request $request) {
        return auth()->user()->makeVisible(['email']);
    });
});