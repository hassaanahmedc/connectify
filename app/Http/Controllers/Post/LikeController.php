<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\Api\LikeRequest;
use App\Models\Post;
use App\Models\User;
use App\Models\Likes;

class LikeController extends Controller
{
    public function store(LikeRequest $request)
    {
        
        $validatedData = $request->validated();

        $post = Post::find($validatedData['posts_id']);
        if (!$post) {
            return response()->json(['error' => 'post not found'], 400);
        }

        $user_id = Auth::id();
    
        $existingLike = Likes::where('posts_id', $validatedData['posts_id'])->where('user_id', $user_id)->first();
    
        if ($existingLike) {
            $existingLike->delete();
            return response()->json(['liked' => false, 'message' => 'Like removed successfully!'], 200);
        }
    
        Likes::create(['posts_id' =>  $validatedData['posts_id'], 'user_id' => $user_id]);
    
        return response()->json(['liked' => true, 'message' => 'Post liked successfully!'], 200);
    }
}