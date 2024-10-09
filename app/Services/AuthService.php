<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    /**
     * @param array $data
     * @return JsonResponse
     */
    public function checkLoginData(array $data): JsonResponse
    {
        $user = User::whereEmail($data['email'])->first();

        if (!$user) {

            return response()->json([
                'message' => 'User not found',
            ], 401);
        }

        if (!Hash::check($data['password'], $user->password)) {

            return response()->json([
                'message' => 'Invalid password.',
            ], 401);
        }

        $user->tokens()->delete();

        $token = $user->createToken('auth')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email
            ],
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function logoutUser(): JsonResponse
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json([
                'message' => 'Invalid token.',
            ]);
        }

        $user->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully',
        ]);
    }
}
