<?php 

namespace App\Services;

use App\Models\Post;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Exception;

Class PostService {
    public function CreatPostWithImages(array $data, $user, $images=null) 
    {
        $newlyStoredPaths = [];
        try {
            return DB::transaction(function () use ($data, $user, $images, $newlyStoredPaths) {
                $post = $user->post()->create(['content' => $data['content']]);
                
                if (isset($data['topics'])) {
                    $post->topics()->sync($data['topics'] ?? []);
                };
    
                if (! empty($images)) {
                    foreach ($images as $image) {
                        if ($image && $image->isValid()) {
                            $result = $image->storeOnCloudinary('posts');
                            $path = $result->getSecurePath();
                            $post->postImages()->create(['path'=> $path]);
                        }
                    }
                }
                return $post->fresh()->load(['user', 'postImages', 'limited_comments', 'topics'])->loadCount(['likes', 'comment']);
            });
        } catch (Exception $e) {
            Log::error('Post Creation Failed', [
                'user_id' => $user->id,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    public function updatePostWithImages(Post $post, array $data, array $removedImageIds = [], array $newImages = [])
    {

        try {
            return DB::transaction(function () use (
                $post, $data, $removedImageIds, $newImages)
                {
                    if (array_key_exists('content', $data)) {
                        $post->content = $data['content'];
                    }

                    if (array_key_exists('topics', $data)) {
                        $post->topics()->sync($data['topics'] ?? []);
                    }

                    if (!empty($removedImageIds)) {
                        $images = $post->postImages()->whereIn('id', $removedImageIds)->delete();
                    }
                    
                    if (!empty($newImages)) {
                        foreach($newImages as $file) {
                            if ($file instanceof UploadedFile && $file->isValid()) {
                                $result = $file->storeOnCloudinary('posts');
                                $path = $result->getSecurePath();

                                $post->postImages()->create(['path' => $path]);
                            }
                        }
                    }

                    $post->save();
                    return $post->fresh()->load(['user', 'postImages', 'limited_comments', 'topics'])->loadCount(['likes', 'comment']);
            });

        } catch (Exception $e) {
            Log::error('Failed to cleanup newly added images after update failure', [
                'path' => $newlyStoredPaths,
                'error' => $e
            ]);
            throw $e;
        }
    }

    public function deletePost(Post $post)
    {
        try {
            DB::transaction(function () use ($post) {
                $post->postImages()->delete();
                $post->delete();
            });
        } catch (Exception $e) {
            Log::error('Failed to delete files on post delete', [
                'post_id' => $post->id,
                'error' => $e
            ]);
        }
    }
}