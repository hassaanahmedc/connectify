<?php

namespace App\Services;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserDiscoveryService
{
    public function exploreUsers(object $user)
    {
        if (!$user) {
            Log::error("User not found, Please login first.");
            return;
        }

        $results = User::where('id', '!=', $user->id)
                    ->whereNotIn('id', $user->following()->pluck('id'))
                    ->orderByRaw('location = ? DESC', [$user->location])
                    ->paginate(15);

        return $results;
    }

    public function UserSuggestions(object $user)
    {
        if (!$user) {
            Log::error("User not found, Please login first.");
            return;
        }

        $results = User::where('id', '!=', $user->id)
                    ->whereNotIn('id', $user->following()->pluck('id'))
                    ->orderByRaw('location = ? DESC', [$user->location])
                    ->inRandomOrder()
                    ->limit(5)
                    ->get();

        return $results;
    }
}