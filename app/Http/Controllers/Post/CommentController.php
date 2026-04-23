<?php

namespace App\Http\Controllers\Post;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
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
        try {
            $validatedData = $request->validated();
            $commentor = $request->user();
            $postOwner = $post->user;
    
            $comment = $post->comment()->create([
                'user_id' => $commentor->id,
                'content' => $validatedData['content'],
            ]);
    
            $comment->load('user');
            if ($postOwner->id !== $commentor->id) {
                $postOwner->notify(new CommentNotification($commentor, $post));
            }
    
            return response()->json([
                'success' => true,
                'commentHtml' => Blade::render('<x-comments :comment="$comment" />', ['comment' => $comment]),
            ]);
        } catch (Exception $e) {
                        Log::error('Comment Controller Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong while loading comments, please try again.',
            ], 500);
        }
    }

    public function loadMore(Request $request, POST $post)
    {
        try {
            $offset = $request->query('offset', 0);
            $limit = $request->query('limit', 5);

            $comments = $post->comment()
                ->with('user')
                ->orderBy('created_at', 'desc')
                ->skip($offset)
                ->take($limit)
                ->get();

            $hasMoreComments = $post->comment()->count() > $offset + $comments->count();
            $html = '';

            foreach ($comments as $comment) {
                $html .= Blade::render('<x-comments :comment="$comment" />', ['comment' => $comment]);
            };

            return response()->json([
                    'success' => true,
                    'hasMoreComments' => $hasMoreComments,
                    'commentHtml' => $html,
                ], 200);

        } catch (Exception $e) {
            Log::error('Comment Controller Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong while loading comments, please try again.',
            ], 500);
        }
    }
    
    public function destroy(Comment $comment)
    {
        try {
            if (Gate::denies('delete', $comment)) {
                return response()->json(['error' => 'You are not allowed to delete this comment'], 403);
            }
            $comment->delete();
            return response()->json(['success' => true], 200);

        } catch (Exception $e) {
            Log::error('Comment Controller Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong while deleting the comment, please try again.',
            ], 500);
        }
    }

    public function update(CommentRequest $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        try {
            $validatedData = $request->validated();
    
            $comment->update(['content' => $validatedData['content']]);

            $comment->load('user');
    
            return response()->json([
                'success' => true,
                'content' => $comment->content,
            ], 201);

        } catch (Exception $e) {
            Log::error('Comment Controller Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong while updating the comment, please try again.',
            ], 500);
        };
    }
    
}
