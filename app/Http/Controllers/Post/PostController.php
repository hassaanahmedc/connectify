<?php

namespace App\Http\Controllers\Post;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\Post\CreatePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Http\Resources\Post\PostCardResource;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Services\PostService;
use Exception;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with(['user', 'postImages', 'limited_comments'])
            ->withCount(['likes', 'comment'])
            ->latest()
            ->get();
        
        return view('profile.index', ['user' => Auth::user(), 'posts' => $posts]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePostRequest $request, PostService $postService)
    {
        $data = $request->validated();

        $images = $request->file('images');

        $post = $postService->CreatPostWithImages($data, auth()->user(), $images);
        
        return response()->json([
            'payload' => $post,
            'postHtml' => view('posts.feed-card', [
                'post' => $post,
                'profileUrl' => route('profile.view', $post->user->id),
                'postId' => $post->id,
                'userName' => $post->user->fname . ' ' . $post->user->lname,
                'postTime' => $post->created_at->diffForHumans(),
                'postContent' => $post->content,
                'postImages' => $post->postImages ?? collect([]),
                'comments' => $post->limited_comments ?? collect([]),
                'profileImageUrl' => $post->user->avatar ?? 'https://placewaifu.com/image/200',
            ])->render(),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Post $post)
    {
        if ($request->query('mode') === 'edit') {
            $post->load(['postImages']);
            return new PostCardResource($post);
        }

        $with = [
            'postImages',
            'user',
            'limited_comments',
        ];

        $post->load($with)->loadCount(['likes', 'comment']);

        return new PostCardResource($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, PostService $postService, Post $post)
    {
        $this->authorize('update', $post);

        $validated = $request->validated();
        $newImages = $request->file('images', []);

        $removedImageIds = $request->input('removedImageIds', []);
        if(is_string($removedImageIds)) $removedImageIds = json_decode($removedImageIds, true) ?: [];
        try {
            $updated_post = $postService->UpdatePostWithImages($post, $validated, $removedImageIds, $newImages);

            $postHtml = view('posts.feed-card', [
                    'post' => $updated_post,
                    'profileUrl' => route('profile.view', $updated_post->user->id),
                    'postId' => $updated_post->id,
                    'userName' => $updated_post->user->fname . ' ' . $updated_post->user->lname,
                    'postTime' => $updated_post->created_at->diffForHumans(),
                    'postContent' => $updated_post->content,
                    'postImages' => $updated_post->postImages ?? collect([]),
                    'comments' => $updated_post->limited_comments ?? collect([]),
                    'profileImageUrl' => $updated_post->user->avatar ?? 'https://placewaifu.com/image/200',
                ])->render();

            return response()->json([
                'success' => true,
                'payload' => new PostCardResource($updated_post),
                'postHtml' => $postHtml
            ]);

        } catch (Exception $e) {
            Log::error('Post update faliled', ['post_id' => $post->id, 'error' => $e]);

            return response()->json(['success' => false, 'error' => 'failed to update post'], 500);
        }
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post, PostService $postService)
    {
        $this->authorize('delete', $post);

        try {
            $postService->deletePost($post);
            return redirect()->back()->with(['success' => true, 'message' => 'Post deleted successfully!']);

        } catch (Exception $e) {
            Log::error('Failed to delete post: ' , ['post_id' => $post->id, 'error' => $e]);
            return redirect()->back()->with(['success' => false, 'message' => 'Failed to delete post: ' . $e]);
        }
    }
}
