<?php

namespace App\Http\Resources\Post;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\Post\PostImageResource;
use App\Http\Resources\Post\CommentResource;

class PostCardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'content' => $this->content,
            'user' => new UserResource($this->whenLoaded('user')),
            'images' => PostImageResource::collection($this->whenLoaded('postImages')),
            'user_avatar' => $this->user->avatar ?? 'https://placewaifu.com/image/200',
            'comments' => CommentResource::collection($this->whenLoaded('limited_comments')),
            'likes_count'    => $this->when(isset($this->likes_count), $this->likes_count),
            'comments_count' => $this->when(isset($this->comment_count), $this->comment_count),
            'created_at' => $this->created_at->toDateTimeString(),
            'profileUrl' => route('profile.view', $this->user->id)
        ];
    }
}