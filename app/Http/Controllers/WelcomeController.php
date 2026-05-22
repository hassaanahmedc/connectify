<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\RendersAjaxPagination;

class WelcomeController extends Controller
{
    use RendersAjaxPagination;

    public function index(Request $request)
    {
        $user_id = Auth::id();
        $userTopicIds = Auth::user()->topics()->pluck('topics.id')->toArray();
        
        $query = Post::query()
            ->with(['user:id,fname,lname,avatar',
                    'postImages:id,posts_id,path',
                    'topics:id,name,slug',
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
            }]);

        if (!empty($userTopicIds)) {
            $query->orderByDesc(function ($q) use ($userTopicIds) {
                $q->selectRaw('count(*)')
                  ->from('post_topic')
                  ->whereColumn('post_topic.post_id', 'posts.id')
                  ->whereIn('post_topic.topic_id', $userTopicIds);
            });
        }

        $posts = $query->latest()->paginate(15);

        if($request->ajax()) {
            return $this->renderAjaxPagination($request, $posts, 'components.post.card', 'post');
        }
        return response()->view('welcome', compact('posts'));
    }
}
