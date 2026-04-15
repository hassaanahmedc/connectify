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
use Illuminate\Support\Facades\Blade;
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
            'postHtml' => Blade::render('<x-post.card :post="$post" />', ['post' => $post]),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Post $post)
    {
        if ($request->query('mode') === 'edit') {
            $this->authorize('update', $post);
            $post->load(['postImages']);
            return new PostCardResource($post);
        }

        $with = ['postImages', 'user', 'limited_comments'];
        $post->load($with)->loadCount(['likes', 'comment']);

        if ($request->expectsJson()) return new PostCardResource($post);
        return view('posts.show', ['user' => Auth::user(), 'posts' => $post]);
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

        return response()->json([
            'payload' => $updated_post,
            'postHtml' => Blade::render('<x-post.card :post="$post" />', ['post' => $updated_post]),
        ], 201);

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
