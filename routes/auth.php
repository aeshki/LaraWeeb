<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'login')
        ->name('login');

    Route::post('/register', 'register')
        ->name('register');
        
    Route::get('/logout', 'logout')
        ->middleware('auth:sanctum')
        ->name('logout');
    
    Route::post('/password/forgot', 'forgotPassword')
        ->name('password.email')
        ->middleware('guest');

    Route::post('/password/reset', 'resetPassword')
        ->name('password.reset')
        ->middleware('guest');
});