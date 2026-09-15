<script setup>
import HeartIcon from "@/Components/Icons/HeartIcon.vue";
import { Form } from "@inertiajs/vue3";

defineProps({
    post: Object,
});
</script>

<template>
    <Form method="POST" :action="route(post.has_liked ? 'posts.unlike' : 'posts.like', [post.profile, post])">
        <div class="flex items-center gap-1">
            <button :class="[
                'hover:text-pixl',
                {
                    'text-pixl': post.has_liked,
                }
            ]" aria-label="Like">
                <HeartIcon />
            </button>
            <span :class="['hover:text-pixl', { 'text-pixl': post.has_liked }]" class="text-sm">
                {{ post.likes_count }}
            </span>

        </div>
    </Form>

</template>
