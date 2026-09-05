<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ApiLoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ApiAuthController extends Controller
{
    public function login(ApiLoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();
        $credentials['role'] = 'student';

        if (! Auth::attempt($credentials)) {
            return response()->json(['message' => 'Email atau password tidak sesuai.'], 422);
        }

        $user = $request->user();
        $token = $user->createToken('educore-mobile')->plainTextToken;

        return response()->json(['token' => $token, 'user' => $user], 200);
    }

    public function logout(): JsonResponse
    {
        request()->user()->currentAccessToken()?->delete();

        return response()->json(['message' => 'Logout berhasil.']);
    }
}
