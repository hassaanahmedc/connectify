<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class WelcomeController extends Controller
{
    public function index()
    {
        $user_id = Auth::id();

        // Force a fresh query to avoid stale data
        $posts = Post::query()
            ->with(['user', 'postImages', 'comment'])
            ->withCount(['likes', 'comment'])
            ->withExists(['likes as liked_by_user' => function ($query) use ($user_id) {
                $query->where('user_id', $user_id);
            }])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->view('welcome', compact('posts'))
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate');
    }
}
