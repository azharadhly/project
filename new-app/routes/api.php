<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserDeleteController;
use App\Http\Controllers\UserUpdateController;



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Register route
Route::post('/register', [RegisterController::class, 'register']);

// Login route
Route::post('/login', [LoginController::class, 'login']);
// Route to delete a user by ID

Route::delete('/user/{id}', [UserDeleteController::class, 'destroy']);
Route::put('/user/{id}', [UserUpdateController::class, 'update']);

