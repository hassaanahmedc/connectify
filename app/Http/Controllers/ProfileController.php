<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Post;
use App\Models\User;
use PhpParser\Node\Stmt\Break_;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */

    public function view(Request $request, User $user) :View
    {
        $isOwnProfile = Auth::check() && Auth::id() === $user->id;
        $currentUserId = Auth::id();

        $user->load(['post' => function ($query) {
            $query->orderBy('created_at', 'desc')
                  ->with('postImages', 'comment')
                  ->withCount(['likes', 'comment']);
        }]);

        $user->post->each(function ($post) use ($currentUserId) {
            $post->liked_by_user = $post->likes()->where('user_id', $currentUserId)->exists();
        });
        
        $user->followed = Auth::check() ? Auth::user()->isFollowing($user) : 'false';
        $user->followers_count = $user->followers()->count();

        return view('profile.index', compact('user', 'isOwnProfile'));

    }

    public function edit(Request $request): View
    {
        return view('profile\settings   ', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request, \App\Models\User $id): RedirectResponse
    {
        $id->update($request->validated());
        return redirect()->back();
        
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
