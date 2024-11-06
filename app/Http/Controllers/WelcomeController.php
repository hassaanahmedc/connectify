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
        
        $posts = Post::with(['user', 'postImages'])
        ->withCount('likes')
        ->orderBy('created_at', 'desc') 
        ->get()
        ->map(function ($post) use ($user_id) {
            $post->liked_by_user = $post->likes()->where('user_id', $user_id)->exists();
            return $post; 
        });
       return view('welcome', compact('posts'));
    }
}
