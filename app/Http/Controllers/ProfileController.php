<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\Profile;
use App\Queries\ProfilePageQuery;
use App\Queries\ProfileWithRepliesQuery;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show(Profile $profile): View
    {
        $profile->loadCount(['following', 'followers']);

        $posts = ProfilePageQuery::for($profile, Auth::user()?->profile)->get();

        return view('profiles.show', ['profile' => $profile, 'posts' => $posts]);
    }

    public function replies(Profile $profile): Factory|View
    {
        $profile->loadCount('following', 'followers');

        $posts = ProfileWithRepliesQuery::for($profile, Auth::user()?->profile)->get();

        return view('profiles.replies', ['profile' => $profile, 'posts' => $posts]);
    }

    public function follow(Profile $profile): JsonResponse
    {
        $authProfile = Auth::user()->profile;

        $follow = Follow::createFollow($authProfile, $profile);

        return response()->json(['follow' => $follow]);
    }

    public function unfollow(Profile $profile): JsonResponse
    {
        $authProfile = Auth::user()->profile;

        $success = Follow::removeFollow($authProfile, $profile);

        return response()->json(['success' => $success]);
    }
}
