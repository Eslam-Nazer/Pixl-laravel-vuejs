<?php

namespace App\Queries;

use App\Models\Post;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class TimelineQuery
{
    public function __construct(
        private Profile $viewer,
    ) {}

    public static function forViewer(Profile $viewer): self
    {
        return new self($viewer);
    }

    private function baseQuery(): Builder
    {
        $followingIds = $this->viewer->following()
            ->pluck('following_profile_id')
            ->prepend($this->viewer->id);

        $posts = Post::whereIn('profile_id', $followingIds)
            ->whereNull('parent_id')
            ->with([
                'profile',
                'repostOf' => fn ($query) => $query
                    ->withCount(['replies', 'likes', 'reposts'])
                    ->with(['profile']),
            ])
            ->withCount(['replies', 'likes', 'reposts'])
            ->withExists([
                'likes as has_liked' => fn (Builder $query) => $query->where('profile_id', $this->viewer->id),
                'reposts as has_reposts' => fn (Builder $query) => $query->where('profile_id', $this->viewer->id),
                'repostOf as like_original' => fn (Builder $query) => $query
                    ->whereHas('likes', fn (Builder $query) => $query->where('profile_id', $this->viewer->id)),
                'repostOf as repost_original' => fn (Builder $query) => $query
                    ->whereHas('reposts', fn (Builder $query) => $query->where('profile_id', $this->viewer->id)),
            ])
            ->latest();

        return $posts;
    }

    public function get(): Collection
    {
        return $this->baseQuery()
            ->get()
            ->map(fn (Post $post) => $this->normalize($post));
    }

    public function paginate(int $perPage = 20): LengthAwarePaginator
    {
        return $this->baseQuery()
            ->paginate($perPage)
            ->through(fn (Post $post) => $this->normalize($post));
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
