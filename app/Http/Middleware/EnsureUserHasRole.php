<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\JsonResponse;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response | JsonResponse
    {
        if (!in_array(auth()->user()->role ?? 'user', $roles)) {
            return response()->json([
                'message' => "You don't have access to this endpoint."
            ], Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
