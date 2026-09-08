<?php

namespace App\Models;

use Database\Factories\FollowFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['follower_profile_id', 'following_profile_id'])]
class Follow extends Model
{
    /** @use HasFactory<FollowFactory> */
    use HasFactory;

    public function follower(): BelongsTo
    {
        return $this->belongsTo(Profile::class, 'follower_profile_id', 'id');
    }

    public function following(): BelongsTo
    {
        return $this->belongsTo(Profile::class, 'following_profile_id', 'id');
    }

    public static function createFollow(Profile $follower, Profile $following): Follow
    {
        if ($follower->id === $following->id) {
            throw new \InvalidArgumentException('A profile can not follow same profile');
        }

        return static::create([
            'follower_profile_id' => $follower->id,
            'following_profile_id' => $following->id,
        ]);
    }

    public static function removeFollow(Profile $follower, Profile $following): bool
    {
        if ($follower->id === $following->id) {
            throw new \InvalidArgumentException('A profile can not unfollow same profile');
        }

        return static::where('follower_profile_id', $follower->id)
            ->where('following_profile_id', $following->id)
            ->delete();
    }
}
