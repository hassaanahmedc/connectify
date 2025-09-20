<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'firstName' => $this->fname,
            'LastName' => $this->lname,
            'email' => $this->email,
            'location' => $this->location,
            'bio' => $this->bio,
            'cover' => $this->cover ? asset("storage/{$this->cover}") : null,
            'avatar' => $this->avatar ? asset("storage/{$this->avatar}") : null,

        ];
    }
}
