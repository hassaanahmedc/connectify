<?php

namespace App\Http\Resources\search;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Http\Resources\Json\JsonResource;

class UserSearchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => 'user',
            'id' => $this->id,
            'title' => trim("{$this->fname} {$this->lname}"),
            'bio' => Str::limit($this->bio, 25),
            'location' => $this->location,
            'avatar' => $this->avatar,
            'url' => route('profile.view', $this->id),
        ];
    }
}
