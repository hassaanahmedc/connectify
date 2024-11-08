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
        $validated = $request->validated();
        $validated['user_id'] = Auth::id();

        $post = Post::create($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image){
                $path = $image->store('images', 'public');
                $post->postImages()->create(['path' => $path]);
            }

                
        }


        return redirect()->back()->with('success', 'Post created successfully!');
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
        $validated = $request->validated();
        $validated['user_id'] = Auth::id();

        $get_post = Post::findOrFail($post);

        $get_post->content = $validated['content'];

        $get_post->save();

        return redirect()->back()->with('success', 'Post updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);

        if (Gate::denies('delete', $post)){
            return redirect()->back()->with('error', 'You are not authorized to delete this post');
        }

        $post->delete();
        return redirect()->back()->with('Success', 'Post deleted successfully!');
    }
}
