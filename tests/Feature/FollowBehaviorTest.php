<?php

use App\Models\Follow;
use App\Models\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('A profile can not follow same profile', function () {
    $profile = Profile::factory()->create();

    expect(fn (): Follow => Follow::createFollow($profile, $profile))
        ->toThrow(InvalidArgumentException::class, 'A profile can not follow same profile');
});

test('A profile can follow another profile', function () {
    $followerProfile = Profile::factory()->create();
    $followingProfile = Profile::factory()->create();

    $follow = Follow::createFollow($followerProfile, $followingProfile);

    expect($followerProfile->following->contains($followingProfile))->toBeTrue()
        ->and($followingProfile->followers->contains($followerProfile))->toBeTrue()
        ->and($follow->follower->is($followerProfile))->toBeTrue()
        ->and($follow->following->is($followingProfile))->toBeTrue();
});

test('A profile can unfollow another profile', function () {
    $followerProfile = Profile::factory()->create();
    $followingProfile = Profile::factory()->create();

    $follow = Follow::createFollow($followerProfile, $followingProfile);

    $success = Follow::removeFollow($followerProfile, $followingProfile);

    expect($followingProfile->following->contains($followingProfile))->toBeFalse()
        ->and($followingProfile->followers->contains($followerProfile))->toBeFalse()
        ->and($follow->fresh())->toBeNull();
});
