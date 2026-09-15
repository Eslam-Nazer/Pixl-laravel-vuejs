<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'profile' => new ProfileResource($this->whenLoaded('profile')),
            'replies' => PostResource::collection($this->whenLoaded('replies')),
            'reposts' => PostResource::collection($this->whenLoaded('reposts')),
            'repost_of' => new PostResource($this->whenLoaded('repostOf')),
            'likes' => LikeResource::collection($this->whenLoaded('likes')),
            'replies_count' => $this->whenCounted('replies'),
            'reposts_count' => $this->whenCounted('reposts'),
            'likes_count' => $this->whenCounted('likes'),
        ];
    }
}
