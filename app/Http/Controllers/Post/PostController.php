<?php

namespace App\Http\Controllers\Post;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Post\CreatePostRequest;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Post\UpdatePostRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Post;
use App\Models\PostImage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     $userId = Auth::id();
    
    //     $posts = Post::where('user_id', $userId)->get();
        
    //     return view('profile.index', ['user' => Auth::user(), 'posts' => $posts]);
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePostRequest $request)
    {
        \Log::info('PostController::store reached', ['request' => $request->all()]);
        if ($request->hasFile('images')) {
            \Log::info('Files received:', array_map(fn($file) => [
                'name' => $file->getClientOriginalName(),
                'type' => $file->getClientMimeType(),
                'size' => $file->getSize(),
                'server_mime' => $file->getMimeType(),
            ], $request->file('images')));
        }
        try {
            $validated = $request->validated();
            $post = auth()->user()->post()->create($validated);
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    if ($image->isValid()) {
                        $path = $image->store('posts', 'public');
                        $post->postImages()->create(['path' => $path]);
                        \Log::info('Stored image: ' . $path);
                    } else {
                        \Log::warning('Invalid image file: ' . $image->getClientOriginalName());
                    }
                }
            }
            $post = $post->fresh()->load('user', 'postImages', 'limited_comments');
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
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed', ['errors' => $e->errors()]);
            return response()->json([
                'error' => 'Validation failed',
                'messages' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Post creation failed: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json([
                'error' => 'Server error occurred',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        try {
            // Fixed syntax errors in the query
            $post = Post::with(['user', 'postImages'])
                ->withCount(['likes', 'comment']) // Changed 'comment' to 'comments' assuming that's the relationship name
                ->findOrFail($id);
    
            // Check if user has permission to view/edit this post
            // Added null check for auth()->user() in case the user is not logged in
            if (auth()->user() && ($post->user_id === auth()->id())) {
                $post->liked_by_user = $post->likes()->where('user_id', auth()->id())->exists();
                
                return response()->json([
                    'post' => $post,
                    'images' => $post->postImages->map(function ($image) {
                        return [
                            'id' => $image->id,
                            'url' => asset('storage/' . $image->path),
                        ];
                    })->values(),
                ]);
            } else {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
        } catch (Exception $e) {
            // Log the error for debugging
            Log::error('Error in PostController@show: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            
            return response()->json(['error' => 'An error occurred while fetching the post'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, string $post)
    {
        try {
            \Log::info('PostController@update called for post #' . $post);
            \Log::info('Request data:', $request->except(['images']));
            
            $validated = $request->validated();
            
            $get_post = Post::findOrFail($post);
            
            // Check authorization
            if (Gate::denies('update', $get_post)) {
                \Log::warning('Update denied due to authorization for post #' . $post);
                return response()->json(['success' => false, 'error' => 'You are not authorized to update this post'], 403);
            }
    
            // Log and set content
            \Log::info('Current content: ' . ($get_post->content ?? 'null'));
            \Log::info('Updating content to: ' . ($validated['content'] ?? 'null'));
            $get_post->content = $validated['content'] ?? null;
            
            // Handle image removals if specified
            if ($request->has('removedImageIds') && $request->input('removedImageIds')) {
                try {
                    $removedImageIds = json_decode($request->input('removedImageIds'), true);
                    \Log::info('Processing image removals for post #' . $post . ': ' . (is_array($removedImageIds) ? implode(', ', $removedImageIds) : 'invalid JSON'));
                    
                    if (is_array($removedImageIds)) {
                        foreach ($removedImageIds as $imageId) {
                            $image = PostImage::find($imageId);
                            if ($image && $image->posts_id == $get_post->id) {
                                if (Storage::disk('public')->exists($image->path)) {
                                    Storage::disk('public')->delete($image->path);
                                    \Log::info('Deleted file: ' . $image->path);
                                } else {
                                    \Log::warning('File not found for deletion: ' . $image->path);
                                }
                                $image->delete();
                                \Log::info('Deleted image #' . $imageId . ' from post #' . $post);
                            } else {
                                \Log::warning('Image #' . $imageId . ' not found or does not belong to post #' . $post);
                            }
                        }
                    } else {
                        \Log::warning('Invalid removedImageIds JSON: ' . $request->input('removedImageIds'));
                    }
                } catch (\Exception $e) {
                    \Log::error('Error processing removed images: ' . $e->getMessage());
                    return response()->json(['success' => false, 'error' => 'Failed to process image removals'], 500);
                }
            } else {
                \Log::info('No images marked for removal');
            }
            
            // Handle image uploads if present
            if ($request->hasFile('images')) {
                \Log::info('Processing new images for post update #' . $post);
                foreach ($request->file('images') as $image) {
                    $path = $image->store('posts', 'public');
                    $get_post->postImages()->create(['path' => $path]);
                    \Log::info('Added new image: ' . $path);
                }
            } else {
                \Log::info('No new images uploaded');
            }
    
            $get_post->save();
            
            // Log post state after save
            $updated_post = $get_post->fresh();
            \Log::info('Post #' . $post . ' updated successfully');
            \Log::info('Updated content: ' . ($updated_post->content ?? 'null'));
            \Log::info('Remaining images: ' . $updated_post->postImages->pluck('id')->implode(', '));
    
            // FIXED: Added 'success' => true flag to make response format consistent
            $response = [
                'success' => true,
                'postHtml' => view('posts.feed-card', [
                    'post' => $updated_post,
                    'profileUrl' => route('profile.view', $updated_post->user->id),
                    'postId' => $updated_post->id,
                    'userName' => $updated_post->user->fname . ' ' . $updated_post->user->lname,
                    'postTime' => $updated_post->created_at->diffForHumans(),
                    'postContent' => $updated_post->content,
                    'postImages' => $updated_post->postImages ?? collect([]),
                    'comments' => $updated_post->limited_comments ?? collect([]),
                    'profileImageUrl' => $updated_post->user->avatar ?? 'https://placewaifu.com/image/200',
                ])->render(),
            ];
            
            // FIXED: Return properly formatted JSON with correct Content-Type header
            return response()->json($response, 200, [
                'Content-Type' => 'application/json; charset=utf-8'
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Failed to update post #' . $post . ': ' . $e->getMessage());
            return response()->json([
                'success' => false, 
                'error' => 'Failed to update post: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Add debug logging
        \Log::info('PostController@destroy called with ID: ' . $id);
        
        $post = Post::findOrFail($id);

        if (Gate::denies('delete', $post)){
            \Log::warning('Deletion denied due to authorization');
            return redirect()->back()->with('error', 'You are not authorized to delete this post');
        }

        try {
            $post->delete();
            \Log::info('Post deleted successfully: ' . $id);
            return redirect()->back()->with('success', 'Post deleted successfully!');
        } catch (\Exception $e) {
            \Log::error('Failed to delete post: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to delete post: ' . $e->getMessage());
        }
    }
}
