<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\LikeController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CommentController;
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
//Public Routes
Route::post('/register', [AuthController::class, 'register']);
//Laravel Defaults
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Protected Rouutes
Route::middleware('auth:sanctum')->group(function () {
    // Likes functionality
    Route::post('posts/like', [LikeController::class, 'store']);

});
