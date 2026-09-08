<?php

namespace App\Queries;

use App\Models\Post;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ProfileWithRepliesQuery
{

    public function __construct(
      private Profile $subject,
      private ?Profile $viewer,
    ) {}

    public static function for(Profile $subject, ?Profile $viewer): self
    {
        return new self($subject, $viewer);
    }

    private function baseQuery(): Builder
    {
        return Post::query()
            ->where(fn ($builder) => $builder
                ->whereBelongsTo($this->subject, 'profile')
                ->whereNull('parent_id')
            )
            ->orWhereHas('replies', fn ($builder) => $builder
                ->whereBelongsTo($this->subject, 'profile')
            )
            ->with([
                'profile',
                'repostOf' => fn ($query) => $query->withCount(['likes', 'reposts', 'replies'])->with('profile'),
                'repostOf.profile',
                'parent.profile',
                'replies' => fn ($query) => $query
                    ->whereBelongsTo($this->subject, 'profile')
                    ->with('profile')
                    ->oldest(),
            ])
            ->withCount(['likes', 'reposts', 'replies'])
            ->withExists([
                'likes as has_liked' => fn (Builder $query) => $query->where('profile_id', $viewerId),
                'reposts as has_reposts' => fn (Builder $query) => $query->where('profile_id', $viewerId),
                'repostOf as like_original' => fn (Builder $query) => $query
                    ->whereHas('likes', fn (Builder $query) => $query->where('profile_id', $viewerId)),
                'repostOf as repost_original' => fn (Builder $query) => $query
                    ->whereHas('reposts', fn (Builder $query) => $query->where('profile_id', $viewerId)),
            ])
            ->latest();
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
