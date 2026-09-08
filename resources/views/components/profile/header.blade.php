<!-- Profile Header -->
<header>
    <!--    Profile Cover    -->
    <img src="{{ $profile->cover_url }}" alt="Cover"/>
    <!-- Profile image -->
    <div
        class="-mt-10 flex flex-wrap items-end justify-between gap-4 md:-mt-16"
    >
        <div class="flex items-end gap-4">
            <img
                src="{{ $profile->avatar_url }}"
                alt="Avatar for {{ $profile->display_name }}"
                class="size-20 object-cover md:size-32"
            />
            <div class="flex flex-col md:gap-1">
                <p class="text-lg md:text-xl">{{ $profile->display_name }}</p>
                <p class="text-pixl-light/60 text-sm">{{ "@$profile->handle "}}</p>
            </div>
        </div>
        <a
            href="#"
            class="bg-pixl-dark/50 hover:bg-pixl-dark/60 text-pixl border-pixl/50 hover:border-pixl/60 border px-2 py-1 text-sm transition-colors"
        >
            Edit profile
        </a>
    </div>

    <div class="[&_a]:text-pixl mt-8 [&_a]:hover:underline">
        <p>I design <a href="#">@Laracasts</a> so hit me up whenever :]</p>
    </div>
    <dl class="mt-6 flex gap-6">
        <div class="flex gap-1.5">
            <dd>{{ $profile->following_count }}</dd>
            <dt class="text-pixl-light/60">Following</dt>
        </div>
        <div class="flex gap-1.5">
            <dd>{{ $profile->followers_count }}</dd>
            <dt class="text-pixl-light/60">Followers</dt>
        </div>
    </dl>
</header>

<!-- Navigation tabs -->
<div class="mt-6 h-full">
    <nav class="scrollbar-none overflow-x-auto">
        <ul class="flex min-w-max justify-end gap-8 text-sm">
            <li>
                <a
                    class="text-pixl-light/60 hover:text-pixl-light/80 hover:underline"
                    href="{{ route('profiles.show', $profile) }}"
                >Posts
                </a>
            </li>
            <li>
                <a
                    class="text-pixl-light/60 hover:text-pixl-light/80 hover:underline"
                    href="{{ route('profiles.replies', $profile) }}"
                >Replies
                </a>
            </li>
            <li>
                <a
                    class="text-pixl-light/60 hover:text-pixl-light/80 hover:underline"
                    href="#"
                >Highlights
                </a>
            </li>
            <li>
                <a
                    class="text-pixl-light/60 hover:text-pixl-light/80 hover:underline"
                    href="#"
                >Inspiration Streams
                </a>
            </li>
        </ul>
    </nav>
</div>
