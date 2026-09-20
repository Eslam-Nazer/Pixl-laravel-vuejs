<script setup>
import HeartIcon from "@/Components/Icons/HeartIcon.vue";
import { Form } from "@inertiajs/vue3";

defineProps({
    post: Object,
});
</script>

<template>
    <Form method="POST" :action="route('posts.like', [post.profile, post])">
        <div class="flex items-center gap-1">
            <button
                class="hover:text-pixl"
                :class="{ 'text-pixl': post.has_liked }"
                aria-label="Like"
                data-test="like-post-button"
            >
                <HeartIcon />
            </button>
            <span
                class="text-sm hover:text-pixl"
                :class="{ 'text-pixl': post.has_liked }"
                data-test="like-post-count"
            >
                {{ post.likes_count }}
            </span>
        </div>
    </Form>
</template>
