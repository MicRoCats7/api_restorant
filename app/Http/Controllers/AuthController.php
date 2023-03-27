<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validation = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        $hashedPassword = Hash::make($validation['password']);

        $userRegister = User::Create([
            'name' => $validation['name'],
            'email' => $validation['email'],
            'role' => 'user',
            'password' => $hashedPassword,
        ]);

        return response([
            'user' => $userRegister,
            'token' => $userRegister->createToken('secret')->plainTextToken
        ], 200);
    }

    public function login(Request $request)
    {
        $validation = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!Auth::attempt($validation)) {
            return response([
                'message' => 'User tidak ditemukan'
            ], 403);
        }

        return response([
            'user' => auth()->user(),
            'token' => auth()->user()->createToken('secret')->plainTextToken
        ], 200);
    }
    public function logout()
    {
        Auth::user()->tokens->each(function ($token, $key) {
            $token->delete();
        });
        return response([
            'message' => 'Berhasil Logout'
        ], 200);
    }
}
