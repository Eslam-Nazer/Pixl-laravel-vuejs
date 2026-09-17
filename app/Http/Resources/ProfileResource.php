<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'display_name' => $this->display_name,
            'handle' => $this->handle,
            'avatar_url' => $this->avatar_url,
            'bio' => $this->bio,
            'cover_url' => $this->cover_url,
            'followers_count' => $this->whenCounted('followers'),
            'following_count' => $this->whenCounted('following'),
        ];
    }
}
