<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;

use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $req)
    {
        if (!Auth::attempt($req->validated())) {
            return response()->json([
                'errors' => [
                    'global' => __('auth.failed')
                ]
            ], 403);
        };
    
        $req->session()->regenerate();

        return response()->json([
            'message' => 'Login Successfully.',
            'user' => Auth::user()
        ]);
    }

    public function register(RegisterRequest $req)
    {
        $user = User::create($req->safe()->all());
        
        Auth::login($user);

        return response()->json([
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
