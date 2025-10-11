<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

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

        if (! array_filter($filters)) {
            $filters['all'] = true;
        }

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
            $users = $usersQuery->limit(10)->get()->map(function ($user) {
                $user->type = 'user';

                return $user;
            });
        }

        if ($filters['posts'] || $filters['all']) {
            $posts = Post::query()->select(['id', 'user_id', 'content', 'created_at'])->where('content', 'like', "%{$q}%")
                ->with('user')->limit(10)->get()->map(function ($post) {
                    $post->type = 'post';

                    return $post;
                });
        }

        $results = $users->concat($posts)->values();

        if ($request->ajax() || $request->wantsJson()) {
            $jsonResults = $results->map(function ($result) {
                if ($result->type === 'user') {
                    return [
                        'type' => 'user',
                        'id' => $result->id,
                        'title' => trim("{$result->fname} {$result->lname}"),
                        'avatar' => $result->avatar,
                        'url' => route('profile.view', $result->id),
                    ];
                }

                if ($result->type === 'post') {
                    return [
                        'type' => 'post',
                        'id' => $result->id,
                        'snipped' => Str::limit($result->content, 50),
                        'created_at' => $result->created_at->diffForHumans(),
                        'user' => [
                            'id' => $result->user->id,
                            'name' => trim("{$result->user->fname} {$result->user->lname}"),
                            'avatar' => $result->user->avatar,
                        ],
                        'url' => route('post.view', $result->id),
                    ];
                }
            });

            return response()->json([
                'query' => $q,
                'filters' => $filters,
                'results' => $jsonResults,
            ]);
        }

        return view('results', compact('results'));
    }

    public function navSearchFilters($type)
    {
        //
    }
}
