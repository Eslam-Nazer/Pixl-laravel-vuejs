<?php

use App\Models\Post;
use App\Models\Profile;

test('authenticated users can view thier timeline', function () {
    $profile = Profile::factory()->create();
    Post::factory()->for($profile)->create();

    $otherProfile = Profile::factory()->create();
    Post::factory()->count(2)->for($otherProfile)->create();

    $this->actingAs($profile->user);

    $profile->follow($otherProfile);

    expect($profile->followings)->toHaveCount(1);

    visit(route('posts.index'))
        ->assertCount('@post-feed-item', 3);
});
