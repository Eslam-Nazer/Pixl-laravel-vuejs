<li class="group/li: relative flex items-start gap-4 pt-4">
    <!-- Line through -->
    <div
        class="bg-pixl-light/10 absolute top-0 left-5 h-full w-px group-last/li:h-4"
        aria-hidden="true"
    ></div>
    <a class="isolate shrink-0" href="{{ route('profiles.show', $post->profile)  }}">
        <img
            class="size-10 object-cover"
            src="{{ $post->profile->avatar_url }}"
            alt="Avatar of {{ $post->profile->display_name }}"
        />
    </a>
    <div class="border-pixl-light/10 grow border-b pt-1.5 pb-5">
        <div class="flex items-center justify-between gap-4">
            <div class="flex items-center gap-2.5">
                <p>
                    <a class="hover:underline"
                       href="{{route('profiles.show', $post->profile) }}">{{ $post->profile->display_name }}</a>
                </p>
                <p class="text-pixl-light/40 text-xs">
                    <a href="{{ route('posts.show', [$post->profile ,$post]) }}">
                        {{ $post->created_at }}
                    </a>
                </p>
                <p>
                    <a
                        class="text-pixl-light/40 hover:text-pixl-light/60 text-xs"
                        href="{{route('profiles.show', $post->profile) }}"
                    >
                        {{ $post->profile->handle }}
                    </a>
                </p>
            </div>
            <button
                class="group flex gap-0.75 py-2"
                type="button"
                aria-label="Post options"
            >
                 <span
                     class="bg-pixl-light/40 group-hover:bg-pixl-light/60 size-1"
                 ></span>
                <span
                    class="bg-pixl-light/40 group-hover:bg-pixl-light/60 size-1"
                ></span>
                <span
                    class="bg-pixl-light/40 group-hover:bg-pixl-light/60 size-1"
                ></span>
            </button>
        </div>
        <div class="mt-4 flex flex-col gap-3 text-sm">
            {!! $post->content !!}
        </div>
        @if($showEngagement)
            <!-- Actions buttons -->
            <div class="mt-6 flex items-center justify-between gap-4">
                <div class="flex items-center gap-8">
                    <!-- Like -->
                    <x-like-button
                        :active="$post->has_liked"
                        :count="$post->likes_count"
                        :id="$post->id"
                    />
                    <!-- Comment -->
                    <x-reply-button :count="$post->replies_count" :id="$post->id" />
                    <!-- Re-post -->
                    <x-repost-button
                        :active="$post->has_reposted"
                        :count="$post->reposts_count"
                        :id="$post->id"
                    />
                </div>
                <div class="flex items-center gap-3">
                    <!-- Save -->
                    <x-save-button :id="$post->id"/>
                    <!-- Share -->
                    <x-share-button :id="$post->id"/>
                </div>
            </div>
        @endif

        @if($showReplies)
            <!-- Threaded replies -->
            <ol>
                <!-- Reply -->
                @foreach($post->replies as $reply)
                    <x-reply :post="$reply" :show-engagement="$showEngagement" :show-replies="$showReplies"/>
                @endforeach
            </ol>
        @endif
    </div>
</li>
