<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Topic;
use App\Models\Likes;
use Aapp\Models\Post;

class TopicController extends Controller
{
    public function getTrending(Request $request, Topic $topic)
    {
        $user_id = Auth::id();

        $topic_posts = $topic->posts()
        ->with([
            'user:id,fname,lname,avatar',
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
        return view('trendingTopic', compact('topic_posts'));
    }
}
