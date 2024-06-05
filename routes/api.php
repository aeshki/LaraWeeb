<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::middleware('auth:sanctum')->group(function() {
    Route::apiResources([
        'posts' => PostController::class,
    ]);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});