<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\Profile;
use App\Queries\ProfilePageQuery;
use App\Queries\ProfileWithRepliesQuery;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Response;

class ProfileController extends Controller
{
    public function show(Profile $profile): Response
    {
        $profile->loadCount(['following', 'followers']);

        $posts = ProfilePageQuery::for($profile, Auth::user()?->profile)->get();

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
