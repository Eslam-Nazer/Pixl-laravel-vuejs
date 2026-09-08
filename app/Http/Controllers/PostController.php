<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Models\Like;
use App\Models\Post;
use App\Models\Profile;
use App\Queries\PostThreadQuery;
use App\Queries\TimelineQuery;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $profile = Auth::user()->profile;

        $posts = TimelineQuery::forViewer($profile)->get();

        return view('posts.index', compact('posts', 'profile'));
    }

    public function show(Profile $profile, Post $post): View
    {
        $post = PostThreadQuery::for($post, Auth::user()?->profile)->load();

        return view('posts.show', compact('post'));
    }

    public function store(CreatePostRequest $request): RedirectResponse
    {
        $profile = $request->user()->profile;

        $post = Post::publish($profile, $request->input('content'));

        return redirect()->route('posts.index');
    }

    public function reply(CreatePostRequest $request, Profile $profile, Post $post): RedirectResponse
    {
        $authProfile = $request->user()->profile;
        $reply = Post::reply($authProfile, $post, $request->input('content'));

        return redirect()->route('posts.index');
    }

    public function repost(Profile $profile, Post $post): RedirectResponse
    {
        $authProfile = Auth::user()->profile;

        $post = Post::repost($authProfile, $post);

        return redirect()->route('posts.index');
    }

    public function quote(Profile $profile, Post $post, CreatePostRequest $request): RedirectResponse
    {
        $authProfile = $request->user()->profile;

        $post = Post::repost($authProfile, $post, $request->input('content'));

        return redirect()->route('posts.index');
    }

    public function like(Profile $profile, Post $post): JsonResponse
    {
        $authProfile = Auth::user()->profile;

        $like = Like::createLike($authProfile, $post);

        return response()->json(compact('like'));
    }

    public function unlike(Profile $profile, Post $post): JsonResponse
    {
        $authProfile = Auth::user()->profile;

        $success = Like::removeLike($authProfile, $post);

        return response()->json(compact('success'));
    }

    public function destroy(Profile $profile, Post $post): JsonResponse
    {
        $authProfile = Auth::user()->profile;
        $success = false;

        if ($authProfile->id === $post->profile_id) {
            $success = $post->delete() > 0;

            return response()->json(compact('success'));
        }

        $repost = $post->reposts()->where('profile_id', $authProfile->id)->first();

        if (! is_null($repost)) {
            $success = $repost->delete() > 0;

            return response()->json(compact('success'));
        }

        return response()->json(compact('success'));
    }
}
