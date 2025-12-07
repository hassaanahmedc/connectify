<?php

namespace app\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Exception;

class AvatarService 
{
    public function update(User $user, UploadedFile $file) 
    {
        $path = $file->store('profile_pictures', 'public');

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->update(['avatar' => $path]);
        return $path;
    }
}