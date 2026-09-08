<?php

declare(strict_types=1);

namespace App\Queries;

use App\Models\Post;
use App\Models\Profile;

class PostThreadQuery
{
    public function __construct(
        private Post $post,
        private ?Profile $profile,
    ) {}

    public static function for(Post $post, ?Profile $profile): self
    {
        return new self($post, $profile);
    }

    public function load(): Post
    {
        $viewerId = $this->profile?->id ?? 0;

        return $this->post->load([
            'replies' => fn ($query) => $query
                ->withCount(['likes', 'replies', 'reposts'])
                ->withExists([
                    'likes as has_liked' => fn ($query) => $query->where('profile_id', $viewerId),
                    'reposts as has_reposted' => fn ($query) => $query->where('profile_id', $viewerId),
                ])
                ->with([
                    'profile',
                    'parent.profile',
                    'replies' => fn ($query) => $query
                        ->withCount(['likes', 'replies', 'reposts'])
                        ->withExists([
                            'likes as has_liked' => fn ($query) => $query->where('profile_id', $viewerId),
                            'reposts as has_reposted' => fn ($query) => $query->where('profile_id', $viewerId),
                        ])
                        ->with(['profile', 'parent.profile'])
                        ->oldest(),
                ])
                ->oldest(),
        ])
            ->loadCount(['likes', 'replies', 'reposts'])
            ->loadExists([
                'likes as has_liked' => fn ($query) => $query->where('profile_id', $viewerId),
                'reposts as has_reposted' => fn ($query) => $query->where('profile_id', $viewerId),
            ]);
    }
}
