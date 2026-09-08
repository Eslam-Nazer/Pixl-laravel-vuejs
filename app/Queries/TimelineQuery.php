<?php

declare(strict_types=1);

namespace App\Queries;

use App\Models\Post;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class TimelineQuery
{
    public function __construct(
        private Profile $profile,
    ) {}

    public static function forViewer(Profile $profile): self
    {
        return new self($profile);
    }

    private function baseQuery(): Builder
    {
        $followingIds = $this->profile->following()
            ->pluck('following_profile_id')
            ->prepend($this->profile->id);

        return Post::whereIn('profile_id', $followingIds)
            ->whereNull('parent_id')
            ->with([
                'profile',
                'repostOf' => fn ($query) => $query
                    ->withCount(['replies', 'likes', 'reposts'])
                    ->with(['profile']),
            ])
            ->withCount(['replies', 'likes', 'reposts'])
            ->withExists([
                'likes as has_liked' => fn (Builder $builder) => $builder->where('profile_id', $this->profile->id),
                'reposts as has_reposts' => fn (Builder $builder) => $builder->where('profile_id', $this->profile->id),
                'repostOf as like_original' => fn (Builder $builder) => $builder
                    ->whereHas('likes', fn (Builder $builder) => $builder->where('profile_id', $this->profile->id)),
                'repostOf as repost_original' => fn (Builder $builder) => $builder
                    ->whereHas('reposts', fn (Builder $builder) => $builder->where('profile_id', $this->profile->id)),
            ])
            ->latest();
    }

    public function get(): Collection
    {
        return $this->baseQuery()
            ->get()
            ->map(fn (Post $post): Post => $this->normalize($post));
    }

    public function paginate(int $perPage = 20): LengthAwarePaginator
    {
        return $this->baseQuery()
            ->paginate($perPage)
            ->through(fn (Post $post): Post => $this->normalize($post));
    }

    private function normalize(Post $post): Post
    {
        if ($post->isRepost() && blank($post->content)) {
            $post->repostOf->has_liked = (bool) $post->like_original;
            $post->repostOf->has_reposted = (bool) $post->repost_original;
        }

        return $post;
    }
}
