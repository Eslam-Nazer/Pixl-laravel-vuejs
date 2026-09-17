<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\Profile;
use App\Queries\ProfilePageQuery;
use App\Queries\ProfileWithRepliesQuery;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Response;

class ProfileController extends Controller
{
    public function show(Profile $profile): Response
    {
        $profile->loadCount(['followings', 'followers']);

        $posts = ProfilePageQuery::for($profile, Auth::user()?->profile)->get();

        $profile->has_followed = Auth::user()->profile->isFollowing($profile);

        return inertia('Profiles/Show', [
            'profile' => $profile->toResource(),
            'posts' => $posts->toResourceCollection(),
        ]);
    }

    public function replies(Profile $profile): Response
    {
        $profile->loadCount('following', 'followers');

        $posts = ProfileWithRepliesQuery::for($profile, Auth::user()?->profile)->get();

        return inertia('Profiles/Show', [
            'profile' => $profile->toResource(),
            'posts' => $posts->toResourceCollection(),
        ]);
    }

    public function follow(Profile $profile): RedirectResponse
    {
        $authProfile = Auth::user()->profile;

        Follow::createFollow($authProfile, $profile);

        return back();
    }

    public function unfollow(Profile $profile): RedirectResponse
    {
        $authProfile = Auth::user()->profile;

        Follow::removeFollow($authProfile, $profile);

        return back();
    }
}
