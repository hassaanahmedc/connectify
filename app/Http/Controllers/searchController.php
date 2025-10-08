<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SearchRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\Post;
use App\Models\User;
use Laravel\Prompts\SearchPrompt;

class searchController extends Controller
{
    public function navSearch(SearchRequest $request)
    {
        $data = $request->validated();
        $q = $data['q'];

        $filters = [
            'all' => $request->boolean('all'),
            'users' => $request->boolean('users'),
            'posts' => $request->boolean('posts'),
            'near' => $request->boolean('near'),
        ];

        if(!array_filter($filters)) $filters['all'] = true;

        $users = collect();
        $posts = collect();

        if ($filters['users'] || $filters['all'] || $filters['near']) {
            $usersQuery = User::query()->select(['id', 'fname', 'lname', 'avatar']);

            $usersQuery->where(function ($w) use ($q) { 
                $w->where('fname', 'like', "%{$q}%")->orWhere('lname', 'like', "%{$q}%");
            });

            if ($filters['near'] && auth()->check() && auth()->user()->city) {
                $usersQuery->where('city', auth()->user()->city);
            }
            $users = $usersQuery->limit(10)->get()->map(function ($u) {
                return [
                    'type' => 'user',
                    'id' => $u->id,
                    'title' => trim("{$u->fname} {$u->lname}"),
                    'avatar' => $u->avatar,
                    'url' => route('profile.view', $u->id),
                ];
            });
        };

        if ($filters['posts'] || $filters['all']) {
            $posts = Post::query()->select(['id', 'content', 'created_at'])->where('content', 'like', "%{$q}%")
                ->limit(10)
                ->get()
                ->map(function ($post) {
                    return [
                        'type' => 'post',
                        'id' => $post->id,
                        'snipped' => Str::limit($post->content, 100),
                        'created_at' => $post->created_at->toDateString(),
                        'url' => route('post.view', $post->id),
                    ];
                });
            }
        $results = $users->concat($posts)->values();
        Log::info(
            ['Search Query' => $q, 
            'Filter' => $filters, 
            'Results' => ['users' => $users, 'posts' => $posts]
        ]);
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'query' => $q,
                'filters' => $filters,
                'results' => $results
            ]);
        }

        return view('results');
    }
    public function navSearchFilters ($type) {
    //
    }
}
