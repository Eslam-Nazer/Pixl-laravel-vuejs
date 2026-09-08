<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Models\Like;
use App\Models\Post;
use App\Models\Profile;
use App\Queries\PostThreadQuery;
use App\Queries\TimelineQuery;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index(): Factory|View
    {
        $profile = Auth::user()->profile;

        $posts = TimelineQuery::forViewer($profile)->get();

        return view('posts.index', ['posts' => $posts, 'profile' => $profile]);
    }

    public function show(Profile $profile, Post $post): View
    {
        $post = PostThreadQuery::for($post, Auth::user()?->profile)->load();

        return view('posts.show', ['post' => $post]);
    }

    public function store(CreatePostRequest $createPostRequest): RedirectResponse
    {
        $profile = $createPostRequest->user()->profile;

        Post::publish($profile, $createPostRequest->input('content'));

        return redirect()->route('posts.index');
    }

    public function reply(CreatePostRequest $createPostRequest, Profile $profile, Post $post): RedirectResponse
    {
        $authProfile = $createPostRequest->user()->profile;
        Post::reply($authProfile, $post, $createPostRequest->input('content'));

        return redirect()->route('posts.index');
    }

    public function repost(Profile $profile, Post $post): RedirectResponse
    {
        $authProfile = Auth::user()->profile;

        Post::repost($authProfile, $post);

        return redirect()->route('posts.index');
    }

    public function quote(Profile $profile, Post $post, CreatePostRequest $createPostRequest): RedirectResponse
    {
        $authProfile = $createPostRequest->user()->profile;

        Post::repost($authProfile, $post, $createPostRequest->input('content'));

        return redirect()->route('posts.index');
    }

    public function like(Profile $profile, Post $post): JsonResponse
    {
        $authProfile = Auth::user()->profile;

        $like = Like::createLike($authProfile, $post);

        return response()->json(['like' => $like]);
    }

    public function unlike(Profile $profile, Post $post): JsonResponse
    {
        $authProfile = Auth::user()->profile;

        $success = Like::removeLike($authProfile, $post);

        return response()->json(['success' => $success]);
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
