<script setup>
import AppFooter from "../../Components/AppFooter.vue";
import BackIcon from "../../Components/Icons/BackIcon.vue";
import Post from "../../Components/Post.vue";
import ProfileHeader from "../../Components/ProfileHeader.vue";
import Layout from "../../Layouts/Layout.vue";
import { Link } from "@inertiajs/vue3";

defineProps({
    profile: Object,
    posts: Array,
});
</script>

<template>
    <Layout>
        <!-- Content -->
        <main class="flex grow flex-col gap-4 overflow-y-auto py-4 sm:px-2">
            <Link
                :href="route('posts.index')"
                class="group flex items-baseline gap-1.5"
            >
                <BackIcon />
                <span class="group-hover:underline">back</span>
            </Link>

            <ProfileHeader :profile="profile" />

            <!-- Feed -->
            <ol class="border-pixl-light/10 border-t pt-4">
                <!-- Feed item -->
                <Post
                    v-for="item in posts"
                    :post="item"
                    :show-engagement="true"
                />
            </ol>

            <!-- Content Footer -->
            <AppFooter />
        </main>
    </Layout>
</template>
