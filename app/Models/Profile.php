<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['user_id', 'display_name', 'avatar_url', 'bio'])]
class Profile extends Model
{
    /** @use HasFactory<\Database\Factories\ProfileFactory> */
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function topLevelPosts(): HasMany
    {
        return $this->hasMany(Post::class)->whereNull('parent_id');
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class, 'profile_id');
    }

    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(
            Profile::class,
            'follows',
            'following_profile_id',
            'follower_profile_id'
        );
    }

    public function following(): BelongsToMany
    {
        return $this->belongsToMany(
            Profile::class,
            'follows',
            'follower_profile_id',
            'following_profile_id'
        );
    }
}
