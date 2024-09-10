<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\{NotFoundHttpException, MethodNotAllowedHttpException};
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Middleware\EnsureUserHasRole;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => EnsureUserHasRole::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (AuthenticationException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => (!empty($e->getMessage()))? $e->getMessage() : 'Unauthorized'
                ], Response::HTTP_UNAUTHORIZED);
            }
        });

        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => (!empty($e->getMessage()))? $e->getMessage() : 'Not found'
                ], Response::HTTP_NOT_FOUND);
            }
        });

        $exceptions->render(function (MethodNotAllowedHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => (!empty($e->getMessage()))? $e->getMessage() : 'Method not found'
                ], Response::HTTP_NOT_FOUND);
            }
        });

        $exceptions->render(function (RouteNotFoundException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => (!empty($e->getMessage()))? $e->getMessage() : 'Route not found'
                ], Response::HTTP_NOT_FOUND);
            }
        });

        $exceptions->render(function (ValidationException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json($e->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        });

        $exceptions->render(function (Throwable $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => (!empty($e->getMessage()))? $e->getMessage() : 'Internal server error'
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        });
    })->create();
