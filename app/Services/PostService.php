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
        return DB::transaction(function () use ($data, $user, $images) {
            $post = $user->post()->create($data);
            if (! empty($images)) {
                foreach ($images as $image) {
                    if ($image && $image->isValid()) {
                        $path = $image->store('posts', 'public');
                        $post->postImages()->create(['path'=> $path]);
                    }
                }
            }
            return $post->fresh()->load(['user', 'postImages', 'limited_comments']);
        });
    }

    public function updatePostWithImages(Post $post, array $data, array $removedImageIds = [], array $newImages = [])
    {
        $removedImageIds = $removedImageIds ?: [];
        $newImages = $newImages ?: [];

        $pathsToDeleteAfterCommit = [];
        $newlyStoredPaths = [];

        try {
            $updatedPost = DB::transaction(function () use (
                $post, $data, $removedImageIds, $newImages, &$pathsToDeleteAfterCommit, &$newlyStoredPaths)
                {
                    if (array_key_exists('content', $data)) {
                        $post->content = $data['content'];
                    }

                    if (!empty($removedImageIds)) {
                        $images = $post->postImages()->whereIn('id', $removedImageIds)->get();
                        foreach($images as $img) {
                            if ($img->path) {
                                Log::info(['Saving img to path to delete: ' => $images]);
                                $pathsToDeleteAfterCommit[] = $img->path;
                            }
                            $img->delete();
                        }
                    }
                    
                    if (!empty($newImages)) {
                        foreach($newImages as $file) {
                            if ($file instanceof UploadedFile && $file->isValid()) {
                                $path = $file->store('posts', 'public');
                                $newlyStoredPaths[] = $path;
                                $post->postImages()->create(['path' => $path]);
                            }
                        }
                    }

                    $post->save();
                    return $post->fresh()->load(['user', 'postImages', 'limited_comments'])->loadCount(['likes', 'comment']);
            });

            if (!empty($pathsToDeleteAfterCommit)) {
                try {
                    Storage::disk('public')->delete($pathsToDeleteAfterCommit);
                } catch (Exception $e) {
                    Log::error('Failed to delete old image files after post update', [
                        'path' => $pathsToDeleteAfterCommit,
                        'error' => $e
                    ]);
                }
            }

            return $updatedPost;
        } catch (Exception $e) {
            if (!empty($newlyStoredPaths)) {
                try{
                    Storage::disk('public')->delete($newlyStoredPaths);
                } catch (Exception $e) {
                    Log::error('Failed to cleanup newly added images after update failure', [
                        'path' => $newlyStoredPaths,
                        'error' => $e
                    ]);
                }
            }
            throw $e;
        }
    }

    public function deletePost(Post $post)
    {
        $path = $post->postImages()->pluck('path')->filter()->toArray();

        DB::transaction(function () use ($post) {
            $post->postImages()->delete();
            $post->delete();
        });
        try {
            Storage::disk('public')->delete($path);
        } catch (Exception $e) {
            Log::error('Failed to delete files on post delete', [
                'path' => $path,
                'error' => $e
            ]);
        }
    }
}