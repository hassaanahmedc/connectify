<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| These routes are loaded by the RouteServiceProvider and assigned to the
| "api" middleware group.
|
*/
//Laravel Defaults
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

