<?php

use App\Models\Post;
use App\Models\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('Allows a profile publish a post', function () {
    $profile = Profile::factory()->create();
    $post = Post::publish($profile, 'Some of content here');

    expect($post->exists)->toBeTrue()
        ->and($post->profile->is($profile))->toBeTrue()
        ->and($post->parent_id)->toBeNull()
        ->and($post->repost_of_id)->toBeNull();
});

test('Can reply to post', function () {
    $originalPost = Post::factory()->create();
    $replier = Profile::factory()->create();

    $reply = Post::reply($replier, $originalPost, 'Reply content');

    expect($reply->parent->is($originalPost))->toBeTrue()
        ->and($originalPost->replies)->toHaveCount(1);
});

test('Post can have many replies', function () {
    $originalPost = Post::factory()->create();
    $replies = Post::factory()->count(4)->reply($originalPost)->create();

    expect($replies->first()->parent->is($originalPost))->toBeTrue()
        ->and($originalPost->replies)->toHaveCount(4)
        ->and($originalPost->replies->contains($replies->first()))->toBeTrue();
});

test('Create plane repost', function () {
    $original = Post::factory()->create();
    $repostProfile = Profile::factory()->create();
    $repost = Post::repost($repostProfile, $original);

    expect($repost->repostOf->is($original))->toBeTrue()
        ->and($original->reposts)->toHaveCount(1)
        ->and($repost->content)->toBeNull();
});

test('Post can have many repost', function () {
    $original = Post::factory()->create();
    $reposts = Post::factory()->count(4)->repost($original)->create();

    expect($reposts->first()->repostOf->is($original))->toBeTrue()
        ->and($original->reposts)->toHaveCount(4)
        ->and($original->reposts->contains($reposts->first()))->toBeTrue();
});

test('Create quote repost', function () {
    $content = 'This is content';
    $original = Post::factory()->create();
    $repostProfile = Profile::factory()->create();
    $repost = Post::repost($repostProfile, $original, $content);

    expect($repost->repostOf->is($original))->toBeTrue()
        ->and($original->reposts)->toHaveCount(1)
        ->and($repost->content)->toBe($content);
});

test('Prevent duplicate reposts', function () {
    $original = Post::factory()->create();
    $profile = Profile::factory()->create();

    $post = Post::repost($profile, $original);
    $repost2 = Post::repost($profile, $original);

    expect($post->id)->toBe($repost2->id);
});

test('Remove repost', function () {
    $original = Post::factory()->create();
    $profile = Post::factory()->repost($original)->create()->profile;

    $success = Post::removeRepost($profile, $original);

    expect($original->reposts)->toHaveCount(0)
        ->and($success)->toBeTrue();
});
