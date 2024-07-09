<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class WelcomeController extends Controller
{
    public function index()
    {
       $posts = Post::with('user')->orderBy('created_at', 'desc')->get();
       return view('welcome', compact('posts'));
    }
}
