<?php

namespace App\Services;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Topic;
use App\Models\Post;

Class TrendingService
{
    public function getTopTopics()
    {
        return Topic::withCount('posts')
            ->withCount(['posts as likes_count' => function (Builder $query) {
                $query->join('likes', 'likes.posts_id', '=', 'posts.id');
                }
            ])->orderByDesc('likes_count')->get();
        
    }
}