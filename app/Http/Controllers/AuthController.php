<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\JsonResponse;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    public function login(LoginRequest $req)
    {
        if (!auth()->attempt($req->validated())) {
            return new JsonResponse([
                'email' => [ 'The provided credentials are incorrect.' ]
            ]);
        };
    
        return new JsonResponse([
            'ok' => true,
            'message' => 'Login.',
            'token' => auth()->user()->createToken('Login')->plainTextToken
        ]);
    }

    public function register(RegisterRequest $req)
    {
        $user = User::create($req->validated());
        $token = $user->createToken('Register')->plainTextToken;

        return new JsonResponse([
            'ok' => true,
            'message' => 'Account created.',
            'token' => $token
        ]);
    }

    public function logout()
    {
        //
    }
}
