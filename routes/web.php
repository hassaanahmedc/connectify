<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Post\LikeController;
use App\Http\Controllers\Post\PostController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route::get('/login', function() {
//     return view('auth/login');
// })->name('login');

Route::middleware('auth')->group(function () {
    Route::get('/profile/view/{user}', [ProfileController::class, 'view'])->name('profile.view');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/{id}', [ProfileController::class, 'update'])->name('profile.update');     
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
});

//Laravel Sanctum Protected routes

Route::middleware('guest')->group(function () {
    Route::view('/register', 'auth/register')->name('register');
    Route::view('/login', 'auth/login')->name('login');
    Route::post('/register', [AuthController::class, 'RegisterUser']);
    Route::post('/login', [AuthController::class, 'Login']);
});

Route::middleware(['auth:sanctum', 'web'])->group(function () {
    Route::get('/', [WelcomeController::class, 'index'])->name('home');
    Route::resource('/post', App\Http\Controllers\Post\PostController::class)->except(['create']);
    Route::post('/logout', [AuthController::class, 'Logout'])->name('logout');
    Route::post('/post/{posts}/like', [LikeController::class, 'store'])->name('post.like');
});

require __DIR__.'/auth.php';