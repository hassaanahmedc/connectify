<?php

namespace App\Http\Resources\search;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Http\Resources\Json\JsonResource;

class PostSearchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => 'post',
            'id' => $this->id,
            'snipped' => Str::limit($this->content, 50),
            'created_at' => $this->created_at->diffForHumans(),
            'url' => route('post.view', $this->id),
            'user' => [
                'id' => $this->user->id,
                'name' => trim("{$this->user->fname} {$this->user->lname}"),
                'avatar' => $this->user->avatar,
            ],
        ];
    }
}
