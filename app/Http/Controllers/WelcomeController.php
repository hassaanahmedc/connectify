<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;

class WelcomeController extends Controller
{
    public function index()
    {
        $user_id = Auth::id();
        
        // Force a fresh query to avoid stale data
        $posts = Post::withoutGlobalScopes()
            ->with(['user', 'postImages'])
            ->withCount(['likes', 'comment'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->fresh() // Ensure fresh data from the database
            ->map(function ($post) use ($user_id) {
                $post->liked_by_user = $post->likes()->where('user_id', $user_id)->exists();
                return $post;
            });

        return response()->view('welcome', compact('posts'))
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate');
    }
}
