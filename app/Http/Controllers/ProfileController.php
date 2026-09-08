<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\Post;
use App\Models\Profile;
use App\Queries\ProfilePageQuery;
use App\Queries\ProfileWithRepliesQuery;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show(Profile $profile): View
    {
        $profile->loadCount(['following', 'followers']);

        $posts = ProfilePageQuery::for($profile, Auth::user()?->profile)->get();

        return view('profiles.show', compact('profile', 'posts'));
    }

    public function replies(Profile $profile)
    {
        $profile->loadCount('following', 'followers');

        $posts = ProfileWithRepliesQuery::for($profile, Auth::user()?->profile)->get();

        return view('profiles.replies', compact('profile', 'posts'));
    }

    public function follow(Profile $profile): JsonResponse
    {
        $authProfile = Auth::user()->profile;

        $follow = Follow::createFollow($authProfile, $profile);

        return response()->json(compact('follow'));
    }

    public function unfollow(Profile $profile): JsonResponse
    {
        $authProfile = Auth::user()->profile;

        $success = Follow::removeFollow($authProfile, $profile);

        return response()->json(compact('success'));
    }
}
