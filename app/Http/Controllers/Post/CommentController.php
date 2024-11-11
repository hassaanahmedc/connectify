<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Post\CommentRequest;
use App\Models\Post;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(CommentRequest $request)
    {
        $validatedData = $request->validated();

        $post = Post::find($validatedData['posts_id']);
        if (!$post) {
            return response()->json(['error' => 'Post not found'], 400);
        }

        $user_id = Auth::id();

        $comment = Comment::create([
            'posts_id' => $validatedData['posts_id'],
            'user_id' => $user_id,
            'content' => $validatedData['content']
        ]);

        return response()->json(['success' => 'Comment added successfully!', 'comment' => $comment], 200);    
    }

    // public function view(Request $request)
    // {
    //     $comments = Comment::where($request->posts_id)->with('user')->orderBy('created_at')->get();
    //     if ($comments->isEmpty()) {
    //         return view('welcome', ['message' => 'No comments found']);
    //     }
    //     return view('welcome', compact('comments'));
    // } 

    // public function loadMore(Request $request, POST $post)
    // {
    //     $offset = $request->query('offset', 0);
    //     $limit = 5;

    //     $comments = $post->comment()->with('user')->orderBy('created_at', 'desc')->skip($offset)->take($limit)->get();

    //     return response()->json(['comments' => $comments], 200);
    // }


}
