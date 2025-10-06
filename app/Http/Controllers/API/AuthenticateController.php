<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthenticateController extends Controller
{
    public function register(Request $request)
    {
        // Logic for user registration
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email',
                'password' => 'required|string|min:8|confirmed',
                'role' => 'required|string|in:' . User::ROLE_STUDENT . ',' . User::ROLE_LECTURER,
            ]);

            $validatedData['password'] = bcrypt($validatedData['password']);

            User::create($validatedData);

            return response()->json(
                [
                    'success' => true,
                    'message' => 'User registered successfully'
                ],
                201
            );
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Registration failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function login(Request $request)
    {
        // Logic for user login
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (auth()->attempt($credentials)) {
            $user = auth()->user();
            $token = $user->createToken('auth_token', ['*'], now()->addDays())->plainTextToken;

            return response()->json([
                'success' => true,
                'access_token' => $token,
                'user' => $user
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials'
            ], 401);
        }
    }

    public function logout()
    {
        // Logic for user logout
        try {
            $user = auth('api')->user();
            $user->tokens()->delete();

            return response()->json([
                'success' => true,
                'message' => 'Logged out successfully',
            ]);
        } catch (\Throwable  $e) {
            return response()->json([
                'success' => false,
                'message' => 'Logged out failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
