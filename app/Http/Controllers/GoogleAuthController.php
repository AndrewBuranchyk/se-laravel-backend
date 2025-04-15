<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\{Log, User};

class GoogleAuthController extends Controller
{
    /**
     * Get Redirect URL to Google
     *
     * @return JsonResponse
     */
    public function getRedirectUrlToGoogle(): JsonResponse
    {
        $url = Socialite::driver('google')->stateless()->redirect()->getTargetUrl();
        return response()->json(['url' => $url]);
    }

    /**
     * Handle Google callback from Google authentication attempt
     *
     * @return JsonResponse
     */
    public function handleGoogleCallback(): JsonResponse
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
            $user = User::updateOrCreate(
                ['email' => $googleUser->email],
                [
                    'name' => $googleUser->name,
                    //'google_id' => $googleUser->id,
                    'password' => bcrypt(str_random(16)),
                ]
            );

            Log::create([
                'user_id' => $user->id,
                'event' => "googleLogin",
            ]);

            return response()->json([
                'token' => $user->createToken($googleUser->email)->plainTextToken,
                'user' => new UserResource($user)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Google authentication failed',
                'error' => $e->getMessage()
            ], Response::HTTP_UNAUTHORIZED);
        }
    }
}
