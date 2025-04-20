<?php

namespace App\Http\Controllers\Post;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Post\CreatePostRequest;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Post\UpdatePostRequest;
use Illuminate\Http\Request;
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
        try {
            // Log request information
            \Log::info('PostController@store called with data: ' . json_encode($request->except(['images'])));
            
            $validated = $request->validated();
            $validated['user_id'] = Auth::id();

            $post = Post::create($validated);

            // Handle image uploads
            if ($request->hasFile('images')) {
                \Log::info('Processing ' . count($request->file('images')) . ' images for post #' . $post->id);
                
                foreach ($request->file('images') as $image) {
                    $path = $image->store('images', 'public');
                    $post->postImages()->create(['path' => $path]);
                }
            }

            \Log::info('Post created successfully, ID: ' . $post->id);
            return redirect()->back()->with('success', 'Post created successfully!');
            
        } catch (\Exception $e) {
            \Log::error('Failed to create post: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Failed to create post: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
                return redirect()->back()->with('error', 'You are not authorized to update this post');
            }

            $get_post->content = $validated['content'];
            
            // Handle image removals if specified
            if ($request->has('removed_images')) {
                try {
                    $removedImageIds = json_decode($request->input('removed_images'), true);
                    \Log::info('Processing image removals for post #' . $post . ': ' . implode(', ', $removedImageIds));
                    
                    foreach ($removedImageIds as $imageId) {
                        $image = PostImage::find($imageId);
                        if ($image && $image->posts_id == $get_post->id) {
                            // Delete the file from storage if it exists
                            if (\Storage::disk('public')->exists($image->path)) {
                                \Storage::disk('public')->delete($image->path);
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
                } catch (\Exception $e) {
                    \Log::error('Error processing removed images: ' . $e->getMessage());
                }
            } else {
                \Log::info('No images marked for removal');
            }
            
            // Handle image uploads if present
            if ($request->hasFile('images')) {
                \Log::info('Processing new images for post update #' . $post);
                
                foreach ($request->file('images') as $image) {
                    $path = $image->store('images', 'public');
                    $get_post->postImages()->create(['path' => $path]);
                    \Log::info('Added new image: ' . $path);
                }
            } else {
                \Log::info('No new images uploaded');
            }

            $get_post->save();
            
            \Log::info('Post #' . $post . ' updated successfully');
            return redirect()->back()->with('success', 'Post updated successfully!');
            
        } catch (\Exception $e) {
            \Log::error('Failed to update post #' . $post . ': ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Failed to update post: ' . $e->getMessage())
                ->withInput();
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
