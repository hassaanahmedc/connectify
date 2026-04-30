<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Auth;

class WelcomeController extends Controller
{
    public function index(Request $request)
    {
        $user_id = Auth::id();
        $topics = Topic::select('id', 'slug', 'name')->get();

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

        if($request->ajax()) {
            $html = '';
            foreach ($posts as $post) {
                $html .= Blade::render('<x-post.card :post="$post" />', ['post' => $post]);
            };

            return response()->json([
                    'success' => true,
                    'markup' => $html,
                    'nextPageUrl' => $posts->nextPageUrl(),
            ], 200);
        }
        return response()->view('welcome', compact('posts', 'topics'));
    }
}
