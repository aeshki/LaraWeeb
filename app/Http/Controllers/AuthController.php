<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    public function login(LoginRequest $req)
    {
        if (!auth()->attempt($req->validated())) {
            return response()->json([
                'errors' => [
                    'global' => 'The provided credentials are incorrect.'
                ]
            ], 403);
        };
    
        $req->session()->regenerate();

        return response()->json([
            'ok' => true,
            'message' => 'Login Successfully.',
            'user' => auth()->user()
        ]);
    }

    public function register(RegisterRequest $req)
    {
        $user = User::create($req->safe()->all());
        
        auth()->login($user);

        return response()->json([
            'ok' => true,
            'message' => 'Account created.',
            'user' => $user
        ]);
    }

    public function logout(Request $req)
    { 
        $req->session()->invalidate();
     
        $req->session()->regenerateToken();

        return response()->json([
            'ok' => true,
            'message' => 'User logout.'
        ]);
    }
}
