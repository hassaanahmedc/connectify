<?php

namespace App\Services;
use App\Models\Post;
use App\Models\User;

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
        $builder = User::query()->select(['id', 'fname', 'lname', 'avatar'])
            ->where(function ($w) use ($query) {
                $w->where('fname', 'like', "%{$query}%")
                    ->orWhere('lname', 'like', "%{$query}%");
        });
        
        if ($filters['near'] && auth()->check() && auth()->user()->city) {
            $builder->where('city', auth()->user()->city);
        }
        
        $users = $builder->limit(10)->get();
        $users->each(fn ($u) => $u->type = 'user');
        return $users;
    }

    public function searchPost(string $query) 
    {
        $builder = Post::query()->select(['id', 'user_id', 'content', 'created_at'])
            ->where('content', 'like', "%{$query}%")->with('user');
        
        $posts = $builder->limit(10)->get();
        $posts->each(fn ($p) => $p->type = 'post');
        return $posts;
    }
}