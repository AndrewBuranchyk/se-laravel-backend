<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\UserResource;
use App\Http\Controllers\{
    LoginController,
    GoogleAuthController,
    CardController,
    UserController,
    DepartmentController,
    LogController
};

Route::post('/login', [LoginController::class, 'authenticate'])->name('login');
Route::get('/auth/google/url', [GoogleAuthController::class, 'getRedirectUrlToGoogle']);
Route::get('/auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return new UserResource($request->user());
    });

    Route::apiResource('cards', CardController::class);

    Route::apiResource('users', UserController::class)
        ->middleware('role:admin,usersAdmin');

    Route::apiResource('departments', DepartmentController::class)
        ->middleware('role:admin');

    Route::apiResource('logs', LogController::class)
        ->only(['index'])
        ->middleware('role:admin');
});


