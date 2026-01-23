<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Services\FollowService;

class FollowController extends Controller
{
    protected $followService;

    public function __construct(FollowService $followService)
    {
        $this->followService = $followService;
    }

    public function toggleFollow(Request $request, User $user)
    {
        $authUser = Auth::user();

        $result = $this->followService->toggle($authUser, $user);

        Log::info(['incomming request for controller:toggleFollow' => $request->all(), 'user' => $user]);
        return response()->json($result, $result['success'] ? 200 : 400);
    }

    public function following(Request $request, User $user)
    {
        $following = $user->isFollowing;

        Log::info(['incomming request for controller:following' => $request->all(), 'user' => $user]);
        return response()->json(['following' => $following], 200);
    }

    public function follower(Request $request, User $user)
    {
        $followers = $user->followers();
        
        Log::info(['incomming request for controller:follower' => $request->all(), 'user' => $user]);
        return response()->json(['followers' => $followers], 200);
    }
}
