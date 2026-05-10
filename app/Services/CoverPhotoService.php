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
        $result = $file->storeOnCloudinary('covers');
        $path = $result->getSecurePath();
        
        $user->update(['cover' => $path]);
        
        return $path;
    }

    public function delete(User $user) 
    {
        $user->update(['cover' => null]);
    }
}