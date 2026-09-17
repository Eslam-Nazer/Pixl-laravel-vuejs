<script setup>
import Logo from "@/Components/Icons/Logo.vue";
import { Link } from "@inertiajs/vue3";
import { route } from "ziggy-js";
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
                    <li>
                        <a
                            class="hover:underline"
                            :href="route('posts.index')"
                            :class="{
                                'text-pixl': $page.component === 'Posts/Index',
                            }"
                            >Home</a
                        >
                    </li>
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
            <Link
                :href="route('posts.index')"
                v-show="$page.component !== 'Posts/Index'"
                class="bg-pixl hover:bg-pixl/90 text-pixl-dark border-transparent px-4 py-2 transition-colors text-center"
            >
                Post
            </Link>
            <div class="flex gap-3.5">
                <Link
                    :href="
                        route('profiles.show', [$page.props.auth.user.profile])
                    "
                >
                    <img
                        class="size-12 shrink-0 object-cover"
                        :src="$page.props.auth.user.profile.avatar_url"
                        :alt="`Image for ${$page.props.auth.user.profile.handle}`"
                    />
                </Link>
                <div class="flex flex-col gap-1 text-sm">
                    <p>{{ $page.props.auth.user.profile.display_name }}</p>
                    <p class="text-pixl-light/60">
                        @{{ $page.props.auth.user.profile.handle }}
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
        </div>
    </header>
</template>
