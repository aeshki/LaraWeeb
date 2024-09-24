<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Mail\PasswordResetMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Response;

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
            'message' => 'User logout.'
        ]);
    }

    public function forgotPassword(Request $req)
    { 
        $req->validate([ 'email' => 'required|email' ]);

        $user = User::where('email', $req->email)->first();
    
        if (!$user) {
            return Response::json(['message' => 'User not found.'], 404);
        }
    
        $token = app('auth.password.broker')->createToken($user);
    
        Mail::to($user->email)->send(new PasswordResetMail($token, $user->email));
    
        return Response::json([ 'message' => 'Reset link sent' ]);
    }

    public function resetPassword(Request $req)
    { 
        $req->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
            'token' => 'required',
        ]);

        Password::reset(
            $req->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = bcrypt($password);
                $user->save();
            }
        );

        return Response::json([
            'message' => 'Password changed successfully'
        ]);
    }
}
