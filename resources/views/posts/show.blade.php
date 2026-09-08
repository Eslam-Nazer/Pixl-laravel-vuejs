<x-layout title="PIXL - Feed">

    <!-- Content -->
    <main class="flex grow flex-col gap-4 overflow-y-auto py-4 sm:px-2">
        <div class="h-full">
            <nav class="scrollbar-none overflow-x-auto">
                <ul class="flex min-w-max justify-end gap-8 text-sm">
                    <li><a class="hover:underline" href="#">For you</a></li>
                    <li>
                        <a
                            class="text-pixl-light/60 hover:text-pixl-light/80 hover:underline"
                            href="#"
                        >Idea streams</a
                        >
                    </li>
                    <li>
                        <a
                            class="text-pixl-light/60 hover:text-pixl-light/80 hover:underline"
                            href="#"
                        >Following</a
                        >
                    </li>
                </ul>
            </nav>
        </div>

        <!-- Feed -->
        <ol class="mt-4">
            <x-post :post="$post" :show-replies="true" />
        </ol>

        <!-- Content Footer -->
        <footer class="mt-10 ml-14">
            <p class="text-center">That's all, folks</p>
            <hr class="border-pixl-light/10 my-4"/>
            <!-- White noise -->
            <div class="h-20 bg-[url(/resources/images/white-noise.gif)]"></div>
        </footer>
    </main>

</x-layout>
