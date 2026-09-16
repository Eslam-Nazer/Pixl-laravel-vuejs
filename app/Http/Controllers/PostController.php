<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Models\Like;
use App\Models\Post;
use App\Models\Profile;
use App\Queries\PostThreadQuery;
use App\Queries\TimelineQuery;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Response;

class PostController extends Controller
{
    public function index(): Response
    {
        $profile = Auth::user()->profile;

        $posts = TimelineQuery::forViewer($profile)->get();

        return inertia('Posts/Index', ['posts' => $posts->toResourceCollection(), 'profile' => $profile->toResource()]);
    }

    public function show(Profile $profile, Post $post): Response
    {
        $post = PostThreadQuery::for($post, Auth::user()?->profile)->load();

        return inertia('Posts/Show', [
            'post' => $post->toResource(),
        ]);
    }

    public function store(CreatePostRequest $createPostRequest): RedirectResponse
    {
        $profile = $createPostRequest->user()->profile;

        Post::publish($profile, $createPostRequest->input('content'));

        return to_route('posts.index');
    }

    public function reply(CreatePostRequest $createPostRequest, Profile $profile, Post $post): RedirectResponse
    {
        $authProfile = $createPostRequest->user()->profile;
        Post::reply($authProfile, $post, $createPostRequest->input('content'));

        return back();
    }

    public function repost(Profile $profile, Post $post): RedirectResponse
    {
        $authProfile = Auth::user()->profile;

        Post::repost($authProfile, $post);

        return to_route('posts.index');
    }

    public function quote(Profile $profile, Post $post, CreatePostRequest $createPostRequest): RedirectResponse
    {
        $authProfile = $createPostRequest->user()->profile;

        Post::repost($authProfile, $post, $createPostRequest->input('content'));

        return to_route('posts.index');
    }

    public function like(Profile $profile, Post $post): RedirectResponse
    {
        $authProfile = Auth::user()->profile;

        Like::createLike($authProfile, $post);

        return back();
    }

    public function unlike(Profile $profile, Post $post): RedirectResponse
    {
        $authProfile = Auth::user()->profile;

        Like::removeLike($authProfile, $post);

        return back();
    }

    public function destroy(Profile $profile, Post $post): JsonResponse
    {
        $authProfile = Auth::user()->profile;
        $success = false;

        if ($authProfile->id === $post->profile_id) {
            $success = $post->delete() > 0;

            return response()->json(['success' => $success]);
        }

        $repost = $post->reposts()->where('profile_id', $authProfile->id)->first();

        if (! is_null($repost)) {
            $success = $repost->delete() > 0;

            return response()->json(['success' => $success]);
        }

        return response()->json(['success' => $success]);
    }
}
