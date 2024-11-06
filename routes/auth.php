<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::view('/register', 'auth/register')->name('register');
    Route::view('/login', 'auth/login')->name('login');
    Route::post('/register', [AuthController::class, 'RegisterUser']);
    Route::post('/login', [AuthController::class, 'Login']);
});

Route::middleware('web', 'auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'Logout'])->name('logout');
});
