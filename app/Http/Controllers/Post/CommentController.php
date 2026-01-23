<?php

namespace App\Http\Controllers\Post;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Post\CommentRequest;
use App\Models\Post;
use App\Models\Comment;
use App\Notifications\CommentNotification;

class CommentController extends Controller
{
    public function store(CommentRequest $request, Post $post)
    {
        $validatedData = $request->validated();

        $commentor = $request->user();
        $postOwner = $post->user;

        $comment = Comment::create([
            'posts_id' => $post->id,
            'user_id' => $commentor->id,
            'content' => $validatedData['content'],
        ]);
        $comment->load('user');
        $commentData = $comment->toArray();
        $commentData['can_delete'] = auth()->user()->can('delete', $comment);
        $commentData['can_update'] = auth()->user()->can('update', $comment);
        
        if ($postOwner->id !== $commentor->id) {
            $postOwner->notify(new CommentNotification($commentor, $post));
        }

        return response()->json(['success' => 'Comment added successfully!', 'comment' => $commentData], 200);
    }

    public function loadMore(Request $request, POST $post)
    {
        $offset = $request->query('offset', 0);
        $limit = $request->query('limit', 5);
        $comments = $post->comment()->with('user')->orderBy('created_at', 'desc')->skip($offset)->take($limit)->get()
            ->map(function ($comment) {
                    return [
                        'id' => $comment->id,
                        'content' => $comment->content,
                        'user' => [
                            'fname' => $comment->user->fname,
                            'lname' => $comment->user->lname,
                            'id' => $comment->user->id,
                        ],
                        'created_at' => $comment->created_at->toISOString(),
                        'can_delete' => auth()->user()->can('delete', $comment),
                        'can_update' => auth()->user()->can('update', $comment),
                    ];
                });
        $hasMoreComments = $post->comment()->count() > $offset + $comments->count();
        return response()->json(['success' => $comments, 'hasMoreComments' => $hasMoreComments], 200);
    }
    
    public function destroy(Comment $comment)
    {
        if (Gate::denies('delete', $comment)) {
            return response()->json(['error' => 'You are not allowed to delete this comment'], 403);
        }
        $comment->delete();
        return response()->json(['success' => 'Comment deleted successfully'], 200);
    }

    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $validatedData = $request->validate([
            'content' => 'required|string|max:255',
        ]);

        $comment->update([
            'content' => $validatedData['content'],
        ]);

        $comment->load('user');
        $commentData = $comment->toArray();
        $commentData['can_delete'] = auth()->user()->can('delete', $comment);
        $commentData['can_update'] = auth()->user()->can('update', $comment);

        return response()->json([
            'success' => 'Comment updated successfully!',
            'comment' => $commentData,
        ], 200);
    }
    
}
