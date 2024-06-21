<?php

namespace App\Http\Controllers\Post;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Post\CreatePostRequest;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\PostImage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::id();
    
        $posts = Post::where('user_id', $userId)->get();
        
        return view('profile.index', ['user' => Auth::user(), 'posts' => $posts]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePostRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = Auth::id();

        Post::create($validated);

        return redirect()->back();  
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
