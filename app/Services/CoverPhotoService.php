<?php

namespace app\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Exception;

class CoverPhotoService 
{
    public function update(User $user, UploadedFile $file)
    {
        $path = $file->store('cover_images', 'public');
        
        if ($user->cover) {
            Storage::disk('public')->delete($user->cover);
        }

        $user->update(['cover' => $path]);
        
        return $path;
    }

    public function remove(User $user) 
    {
        if ($user->cover) {
            Storage::disk('public')->delete($user->cover);
        }

        $user->update(['cover' => null]);
    }
}