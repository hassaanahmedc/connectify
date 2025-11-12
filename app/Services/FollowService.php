<?php

namespace App\Services;

use App\Models\User;
use Exception;

class FollowService
{
    public function toggle(User $authUser, User $targetUser)
    {
        if ($authUser->id === $targetUser->id) {
            throw new Exception('You cannot follow/unfollow yourself');
            return [
                'success' => false,
                'message' => 'You cannot follow/unfollow yourself',
                'following' => false,
            ];
        }

        if ($authUser->isFollowing($targetUser)) {
            $authUser->unfollow($targetUser);
            return [
                'success' => true,
                'message' => 'unfollowed user',
                'following' => false,
                'followers_count' => $targetUser->followers()->count()
            ];
        } else {
            $authUser->follow($targetUser);
            return [
                'success' => true,
                'message' => 'followed user',
                'following' => true,
                'followers_count' => $targetUser->followers()->count()
            ];
        }
    }
}
