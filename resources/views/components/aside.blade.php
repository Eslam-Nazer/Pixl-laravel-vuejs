<aside
    class="-mx-4 my-4 hidden w-80 shrink-0 overflow-y-auto px-4 lg:block"
>
    <input
        aria-label="Search"
        class="w-full text-sm"
        type="text"
        placeholder="#Search an idea or pixel"
    />
    <hr class="border-pixl-light/10 mt-2 border"/>
    <!-- Artists to follow -->
    <x-artists-to-follow />

    <!-- Follow idea streams -->
    <div class="border-pixl-light/10 mt-4 border p-4">
        <h2 class="text-pixl-light/60 text-sm">Follow Idea Streams</h2>

        <ol class="mt-4 flex flex-col gap-2.5">
            <li class="flex items-center justify-between gap-4">
                <p class="truncate text-sm">Breakfast ideas and whatever</p>
                <button
                    class="bg-pixl-dark/50 hover:bg-pixl-dark/60 text-pixl border-pixl/50 hover:border-pixl/60 border px-1.5 py-0.5 text-2xl leading-none transition-colors"
                >
                    +
                </button>
            </li>
            <li class="flex items-center justify-between gap-4">
                <p class="truncate text-sm">Quick book to read</p>
                <button
                    class="bg-pixl-dark/50 hover:bg-pixl-dark/60 border-pixl/50 hover:border-pixl/60 text-pixl grid size-7 shrink-0 place-items-center border text-2xl leading-none"
                >
                    +
                </button>
            </li>
            <li class="flex items-center justify-between gap-4">
                <p class="truncate text-sm">Inspiration for Art</p>
                <button
                    class="bg-pixl-dark/50 hover:bg-pixl-dark/60 border-pixl/50 hover:border-pixl/60 text-pixl grid size-7 shrink-0 place-items-center border text-2xl leading-none"
                >
                    +
                </button>
            </li>
        </ol>
        <a href="#" class="text-pixl-light/60 mt-4 inline-block text-sm"
        >Show more</a
        >
    </div>
</aside>
