<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Http\Requests\Api\LikeRequest;
use App\Models\Post;
use App\Models\User;
use App\Models\Likes;

class LikeController extends Controller
{
    public function index() 
    {
        return response()->json('hello user', 200);
    }

    public function store(LikeRequest $request)
    {
        
        $validatedData = $request->validated();
        $post_id = $validatedData['posts_id'];
        $user_id = $validatedData['user_id'];
    
        $existingLike = Likes::where('posts_id', $post_id)->where('user_id', $user_id)->first();
    
        if ($existingLike) {
            $existingLike->delete();
            return response()->json(['liked' => false, 'message' => 'Like removed successfully!'], 200);
        }
    
        Likes::create(['posts_id' => $post_id, 'user_id' => $user_id]);
    
        return response()->json(['liked' => true, 'message' => 'Post liked successfully!'], 200);
    }
}
