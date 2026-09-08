<div class="border-pixl-light/10 mt-10 border p-4">
    <h2 class="text-pixl-light/60 text-sm">Artists to Follow</h2>

    <ol class="mt-4 flex flex-col gap-4">
        @foreach($profiles as $profile)
            <li class="flex items-center justify-between gap-4">
                <div class="flex items-center gap-2">
                    <img
                        class="size-8 object-cover"
                        src="{{ $profile->avatar_url }}"
                        alt="Avatar of {{ $profile->display_name }}"
                    />
                    <p class="truncate text-sm">{{ $profile->handle }}</p>
                </div>
                <button
                    class="bg-pixl-dark/50 hover:bg-pixl-dark/60 text-pixl border-pixl/50 hover:border-pixl/60 border px-2 py-1 text-sm transition-colors"
                >
                    Follow
                </button>
            </li>
        @endforeach
    </ol>
    <a href="#" class="text-pixl-light/60 mt-4 inline-block text-sm"
    >Show more</a
    >
</div>
