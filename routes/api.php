<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\UserPostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::middleware('auth:sanctum')->group(function() {
    Route::apiResources([
        'posts' => PostController::class,
        'users' => UserController::class,
    ]);

    Route::resource('users.posts', UserPostController::class);
    
    Route::get('/user', function (Request $request) {
        return auth()->user()->makeVisible(['email']);
    });
});