<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'login');
    Route::post('/register', 'register');
});

Route::apiResources([
    'posts' => PostController::class,
]);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');