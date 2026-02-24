<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class WelcomeController extends Controller
{
    public function index()
    {
        $user_id = Auth::id();

        $posts = Post::query()
            ->with(['user:id,fname,lname,avatar',
                    'postImages:id,posts_id,path',
                    'topics:id,name',
                    'comment' => function($q) {
                        $q->select('id', 'posts_id', 'user_id', 'content', 'created_at')
                            ->with('user:id,fname,lname,avatar')
                            ->latest()
                            ->limit(5);
                        }
                    ])
            ->withCount(['likes', 'comment'])
            ->withExists(['likes as liked_by_user' => function ($query) use ($user_id) {
                $query->where('user_id', $user_id);
            }])
            ->latest()
            ->paginate(15);

        return response()->view('welcome', compact('posts'));
    }
}
