<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Http\Resources\Json\JsonResource;

class SearchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        if ($this->type === 'user') {
            return [
                'type' => 'user',
                'id' => $this->id,
                'title' => trim("{$this->fname} {$this->lname}"),
                'avatar' => $this->avatar,
                'url' => route('profile.view', $this->id),
            ];
        };

        if ($this->type === 'post') {
            return [
                'type' => 'post',
                'id' => $this->id,
                'snipped' => Str::limit($this->content, 50),
                'created_at' => $this->created_at->diffForHumans(),
                'user' => [
                    'id' => $this->user->id,
                    'name' => trim("{$this->user->fname} {$this->user->lname}"),
                    'avatar' => $this->user->avatar,
                ],
                'url' => route('post.view', $this->id),
            ];
        };
    }
}
