<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\UserResource;
use App\Http\Controllers\{LoginController, UserController, DepartmentController, CardController};

Route::post('/login', [LoginController::class, 'authenticate'])->name('login');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return new UserResource($request->user());
    });

    Route::apiResource('users', UserController::class)
        ->middleware('role:admin,usersAdmin');
    Route::apiResource('departments', DepartmentController::class)
        ->middleware('role:admin');
    Route::apiResource('cards', CardController::class);
});


