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
        try {
            $data = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:4'],
            ]);

        // TODO: fix this
        // if (User::where('email', $data['email'])->exists()) {
        //     return response()->json(['message' => 'Email already exists'], 400);
        // }

        $user = User::Create($data);
        $token = $user->createToken('auth_token')->plainTextToken;

            $data['access_token'] = $token;
            $data['token_type'] = 'Bearer';
            
            return response()->json([
                'success' => true,
                'data' => $data
            ],201);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ],400);
        }
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:4'],
        ]);

        $user = User::where('email', $data['email'])->first();
        if (!$user || !Hash::check($data['password'], $user->password)) {
            // return response([
            //     'message' => 'The provided credentials are incorrect.',
            // ], 401);
            return response()->json(['message' => 'Invalid login details'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        // return response([
        //     'access_token' => $token,
        // ], 201);
        $data['access_token'] = $token;
        $data['token_type'] = 'Bearer';
        
        return response()->json([
            'success' => true,
            'data' => $data
        ],200);
    }

}
