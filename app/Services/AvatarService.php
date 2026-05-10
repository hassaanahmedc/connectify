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
        $result = $file->storeOnCloudinary('avatars');
        $path = $result->getSecurePath();

        $user->update(['avatar' => $path]);
        return $path;
    }

    public function delete(User $user)
    {   
        $user->update(['avatar' => null]);
    }
}