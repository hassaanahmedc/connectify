<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\searchController;
use App\Http\Controllers\Post\LikeController;
use App\Http\Controllers\Post\CommentController;
use App\Http\Controllers\Post\PostController;
use App\Http\Controllers\FollowController;
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

Route::middleware('auth')->group(function () {
    Route::get('/profile/view/{user}', [ProfileController::class, 'view'])->name('profile.view');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/{id}', [ProfileController::class, 'update'])->name('profile.update');     
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
});

//Laravel Sanctum Protected routes
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/', [WelcomeController::class, 'index'])->name('home');
    // User Profile Routes
    Route::post('/profile/upload-picture', [ProfileController::class, 'uploadPicture'])->name('profile.upload.picture');
    // Post Routes
    Route::post('/post/store', [PostController::class, 'store'])->name('post.store');
    Route::delete('/post/{post}/destroy', [PostController::class, 'destroy'])->name('post.destroy');
    Route::put('/post/{post}/update', [PostController::class, 'update'])->name('post.update');
    Route::post('/post/{post}/like', [LikeController::class, 'store'])->name('post.like');
    // Comment Routes
    Route::post('/post/{post}/comment', [CommentController::class, 'store'])->name('post.comment');
    Route::delete('/post/{comment}/delete', [CommentController::class, 'destroy'])->name('comment.delete');
    Route::patch('/post/{comment}/update', [CommentController::class, 'update'])->name('comment.update');
    // Follow Routes
    Route::post('/user/{user}/follow', [FollowController::class, 'toggleFollow'])->name('user.follow');
    Route::get('/user/{user}/followers', [FollowController::class, 'follower'])->name('user.followers');
    Route::get('/user/{user}/following', [FollowController::class, 'following'])->name('user.following');

});
// Non Protected Public routes
Route::get('/search/results', [searchController::class, 'navSearch'])->name('search.results');
Route::get('/post/{post}', [PostController::class, 'show'])->name('post.view');
Route::get('/post/{post}/viewcomments', [CommentController::class, 'loadMore']);

require __DIR__.'/auth.php';    