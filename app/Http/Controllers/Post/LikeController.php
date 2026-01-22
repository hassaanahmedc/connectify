<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\Post;
use App\Models\User;
use App\Models\Likes;
use App\Notifications\LikeNotification;

class LikeController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $liker = $request->user();
        $postOwner = $post->user;
        
        $existingLike = Likes::where('posts_id', $post->id)->where('user_id', $liker->id)->first();
    
        if ($existingLike) {
            $existingLike->delete();
            return response()->json(['liked' => false, 'message' => 'Like removed successfully!'], 200);
        }
    
        Likes::create(['posts_id' =>  $post->id, 'user_id' => $liker->id]);

        if ($postOwner->id !== $liker->id) {
            $postOwner->notify(new LikeNotification($liker, $post));
        }

        return response()->json(['liked' => true, 'message' => 'Post liked successfully!'], 200);
    }
}