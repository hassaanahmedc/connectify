<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\User\ProfilePictureRequest;
use App\Http\Requests\User\CoverPhotoRequest;
use App\Services\AvatarService;
use App\Services\CoverPhotoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Post;
use App\Models\User;
use App\Models\Topic;
use PhpParser\Node\Stmt\Break_;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */

    private function getProfileBaseData(User $user)
    {
        $user->load('topics:id,name,slug');
        $user->loadCount(['followers', 'following']);
        $topics = Topic::select('id', 'slug', 'name')->get();

        return [
            'user' => $user,
            'topics' => $topics,
            'isOwnProfile' => Auth::id() === $user->id,
        ];
    }

    public function view(Request $request, User $user) :View
    {
        $currentUserId = Auth::id();
        
        $data = $this->getProfileBaseData($user);
        
        $user->load([
            'post' => function ($query) use ($currentUserId) {
            $query->latest()
                  ->with(['postImages', 'comment', 'topics' => fn($q) => $q->select('id', 'name')])
                  ->withCount(['likes', 'comment'])
                  ->withExists(['likes as liked_by_user' => function ($q) use ($currentUserId) {
                    $q->where('user_id', $currentUserId);
                  }]);
        }]);

        $data['viewTab'] = 'posts';

        return view('profile.index', $data);
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

    public function uploadPicture(ProfilePictureRequest $request, AvatarService $service) 
    {
        $user = $request->user();
        $file = $request->validated()['profile_picture'];
        
        try {
            $path = $service->update($user, $file);
            
            return response()->json([
                'status' => 'success',
                'message' => 'Profile picture updated successfully',
                'path' => asset("storage/{$path}")
            ]);
        } catch (Exception $e) {
            Log::error("Avatar Update Error: " . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to upload profile picture. Please try again.'
            ], 500);
        }
    }

    public function deletePicture(Request $request, AvatarService $service)
    {
        $user = $request->user();

        if (!$user->avatar) {
            return response()->json([
                'status' => 'error',
                'message' => 'User does not have a profile picture to delete.'
            ], 422);
        }
        
        try {
            $service->delete($user);
            $user->refresh();

            return response()->json([
                'status' => 'success',
                'message' => 'Profile picture deleted successfully',
                'path' => $user->avatar_url
            ], 200);

        } catch (Exception $e) {
            Log::error("Avatar Delete Error: " . $e->getMessage());

            return response->json([
                'status' => 'error',
                'message' => 'Failed to delete profile picture. Please try again.'
            ], 500);
        }
    }

    public function uploadCover(CoverPhotoRequest $request, CoverPhotoService $service)
    {
        $user = $request->user();
        $file = $request->validated()['cover_photo'];

        try {
            $path = $service->update($user, $file);

            return response()->json([
                'status' => 'success',
                'message' => 'Cover Image updated successfully',
                'path' => asset("storage/{$path}")
            ]);

        } catch (Exception $e) {
            Log::error("Cover Photo Update Rrror: " . $e->getMessage());
            
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to upload cover photo. Please try again.'
            ], 500);
        }
    }

    public function deleteCover(Request $request, CoverPhotoService $service)
    {
        $user = $request->user();

        if (!$user->cover) {
            return response()->json([
                'status' => 'error',
                'message' => 'User does not have a cover photo to delete.'
            ], 422);
        };
        
        try {
            $service->delete($user);
            $user->refresh();

            return response()->json([
                'status' => 'success',
                'message' => 'Cover photo deleted successfully',
                'path' => $user->cover_url
            ], 200);

        } catch (Exception $e) {
            Log::error("Cover Delete Error: " . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete cover photo. Please try again.'
            ], 422);
        };
    }

    public function following(Request $request, User $user) 
    {
        $data = $this->getProfileBaseData($user);

        $data['followingList'] = $user->following()->paginate(15);
        $data['viewTab'] = 'following';

        return view('profile.index', $data);
    }

    public function followers(Request $request, User $user) 
    {
        $data = $this->getProfileBaseData($user);

        $data['followersList'] = $user->followers()->paginate(15);
        $data['viewTab'] = 'followers';

        return view('profile.index', $data);
    }
}
