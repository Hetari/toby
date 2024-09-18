<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Register a new user
    public function register(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:4',
            ]);

            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'success' => true,
                'access_token' => $token,
                'token_type' => 'Bearer',
            ], 201);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    // Login existing user
    public function login(Request $request)
    {
        try {
            $data = $request->validate([
                'email' => 'required|string|email|max:255',
                'password' => 'required|string|min:4',
            ]);

            $user = User::where('email', $data['email'])->first();

            if ($user && Hash::check($data['password'], $user->password)) {
                $token = $user->createToken('auth_token')->plainTextToken;

                return response()->json([
                    'success' => true,
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                    'user_id' => $user->id,
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid credentials',
                ], 401);
            }
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        // return response([
        //     'access_token' => $token,
        // ], 201);
        $data['access_token'] = $token;
        $data['token_type'] = 'Bearer';

        return response()->json([
            'success' => true,
            'message' => 'User logged in successfully',
            'error' => [],
            'data' => $data
        ], 400);
    }
}