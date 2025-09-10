<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Post;
use App\Models\User;

class searchController extends Controller
{
    public function navSearch(Request $request)
    {
        $data = $request->validate([
           'q' => ['required', 'string', 'min:2']
        ]);
        
        $q = $data['q'];

        $users = User::query()->select(['id', 'fname', 'lname', 'avatar'])->where(function($w) use ($q) {
            $w->where('fname', 'like', "%{$q}%")->orWhere('lname', 'like', "%{$q}%");
        })
        ->limit(5)
        ->get()
        ->map(function($u) {
            return [
                'type' => 'user',
                'id' => $u->id,
                'title' => trim("{$u->fname} {$u->lname}"),
                'avatar' => $u->avatar,
                'url' => route('profile.view',$u->id),
            ];
        });

        $posts = Post::query()->select(['id', 'content', 'created_at'])->where('content', 'like', "%{$q}%")
        ->limit(5)
        ->get()
        ->map(function($post) {
            return [
                'type' => 'post',
                'id' => $post->id,
                'snipped' => Str::limit($post->content, 100),
                'created_at' => $post->created_at->toDateString(),
                'url' => route('post.view', $post->id),
            ];
        });

        $results = $users->concat($posts)->values();
        return response()->json([
            'query' => $q,
            'results' => $results
        ]);
    }   
}