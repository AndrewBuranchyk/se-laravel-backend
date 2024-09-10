<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;

class LoginController extends Controller
{
    /**
     * Handle an authentication attempt.
     */
    public function authenticate(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Invalid credential'
            ], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json([
            'token' => $request->user()->createToken($credentials['email'])->plainTextToken,
            'user' => new UserResource($request->user())
        ]);
    }
}
