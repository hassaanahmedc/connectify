<?php

namespace App\Services;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

Class SearchService {
    
    public function search(string $query, array $filters) 
    {
        $users = collect();
        $posts = collect();

        if ($filters['users'] || $filters['all'] || $filters['near']) {
            $users = $this->searchUser($query, $filters);
        }

        if ($filters['posts'] || $filters['all']) {
            $posts = $this->searchPost($query);
        }

        return $users->concat($posts)->values();
    }

    public function searchUser(string $query, array $filters) 
    {
        $builder = User::query()->select(['id', 'fname', 'lname', 'avatar', 'bio', 'location'])
            ->where(function ($w) use ($query) {
                $w->where('fname', 'like', "%{$query}%")
                    ->orWhere('lname', 'like', "%{$query}%");
        });
        
        if ($filters['near'] && auth()->check() && auth()->user()->location) {
            $builder->where('city', auth()->user()->location);
        }
        
        $users = $builder->limit(10)->get();
        $users->each(fn ($u) => $u->type = 'user');
        return $users;
    }

    public function searchPost(string $query) 
    { 
        $user_id = Auth::id();
        $builder = Post::query()->select(['id', 'user_id', 'content', 'created_at'])
            ->where('content', 'like', "%{$query}%")->with('user')->withCount(['likes', 'comment'])
            ->withExists(['likes as liked_by_user' => function ($query) use ($user_id) {
                $query->where('user_id', $user_id);
            }]);
        
        $posts = $builder->limit(10)->get();
        $posts->each(fn ($p) => $p->type = 'post');
        return $posts;
    }
}