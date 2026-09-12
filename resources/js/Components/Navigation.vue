<script setup>
import Logo from "@/Components/Icons/Logo.vue";
</script>
<template>

    <!-- Navigation -->
    <header
        class="my-4 hidden w-48 shrink-0 flex-col justify-between gap-8 pl-4 sm:flex xl:ml-40"
    >
        <div class="overflow-y-auto">
            <!--   Logo   -->
            <a href="/">
                <Logo />
            </a>
            <!-- Navigation -->
            <nav class="mt-10">
                <ul class="flex flex-col gap-3.5">
                    <li><a class="hover:underline" :href="route('posts.index')">Home</a></li>
                    <li><a class="hover:underline" href="#">Explore</a></li>
                    <!-- Active item -->
                    <li class="-ml-4 flex items-center gap-2">
                        <div class="bg-pixl size-2 shrink-0"></div>
                        <a class="hover:underline" href="#">Notification</a>
                    </li>
                    <li><a class="hover:underline" href="#">Lists</a></li>
                    <li><a class="hover:underline" href="#">Bookmarks</a></li>
                    <li><a class="hover:underline" href="#">Jobs</a></li>
                    <li><a class="hover:underline" href="#">Communities</a></li>
                    <li><a class="hover:underline" href="#">Premium</a></li>
                    <li><a class="hover:underline" href="#">Profile</a></li>
                    <li><a class="hover:underline" href="#">More</a></li>
                </ul>
            </nav>
        </div>

        <!--! User controls -->
        <div class="flex flex-col gap-6">
            <button
                class="bg-pixl hover:bg-pixl/90 text-pixl-dark border-transparent px-4 py-2 transition-colors"
            >
                Post
            </button>
            <div class="flex gap-3.5">
                <a href="/profile.blade">
                    <img
                        src="/images/adrian.png"
                        alt="Image for Adrian"
                        class="size-12 shrink-0 object-cover"
                    />
                </a>
                <div class="flex flex-col gap-1 text-sm">
                    <p>_adrian</p>
                    <p class="text-pixl-light/60">@tudssss</p>
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
        </div>
    </header>

</template>
