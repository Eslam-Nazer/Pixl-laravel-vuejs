<?php

use App\Models\Post;
use App\Models\Profile;

it('like a post', function () {
    $profile = Profile::factory()->create();

    $otherProfile = Profile::factory()->create();
    $post = Post::factory()->for($otherProfile)->create();

    $this->actingAs($profile->user);

    visit(route('posts.index'))
        ->assertSee($post->content)
        ->click('@like-post-button')
        ->assertSeeIn('@like-post-count', 1);

    expect($post->likes)->toHaveCount(1);
});
