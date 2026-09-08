<?php

declare(strict_types=1);

namespace App\Queries;

use App\Models\Post;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ProfilePageQuery
{
    public function __construct(
        private Profile $subject,
        private ?Profile $viewer
    ) {}

    public static function for(Profile $subject, ?Profile $viewer): self
    {
        return new self($subject, $viewer);
    }

    private function baseQuery(): Builder
    {
        $viewerId = $this->viewer?->id ?? 0;

        return Post::where('profile_id', $this->subject->id)
            ->whereNull('parent_id')
            ->with([
                'repostOf' => fn ($query) => $query->withCount(['likes', 'reposts', 'replies'])->with('profile'),
            ])
            ->withCount(['likes', 'reposts', 'replies'])
            ->withExists([
                'likes as has_liked' => fn (Builder $builder) => $builder->where('profile_id', $viewerId),
                'reposts as has_reposts' => fn (Builder $builder) => $builder->where('profile_id', $viewerId),
                'repostOf as like_original' => fn (Builder $builder) => $builder
                    ->whereHas('likes', fn (Builder $builder) => $builder->where('profile_id', $viewerId)),
                'repostOf as repost_original' => fn (Builder $builder) => $builder
                    ->whereHas('reposts', fn (Builder $builder) => $builder->where('profile_id', $viewerId)),
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
