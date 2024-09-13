<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
                'message' => 'User created successfully',
                'error' => [],
                'data' => $data
            ], Response::HTTP_CREATED);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating user',
                'error' => $e->getMessage(),
                'data' => []
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
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
            return response()->json([
                'success' => false,
                'message' => 'Invalid login details',
                'error' => [],
                'data' => []
            ], Response::HTTP_UNAUTHORIZED);
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        // return response([
        //     'access_token' => $token,
        // ], 201);
        $data['access_token'] = $token;
        $data['token_type'] = 'Bearer';

        return response()->json([
            'success' => true,
            'message' => 'Error creating user',
            'error' => [],
            'data' => $data
        ], Response::HTTP_OK);
    }
}
