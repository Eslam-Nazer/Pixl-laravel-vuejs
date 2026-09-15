<script setup>
import RepeatIcon from "@/Components/Icons/RepeatIcon.vue";
import { Form } from "@inertiajs/vue3";
import { route } from "ziggy-js";

defineProps({
    post: Object,
});
</script>

<template>
    <Form method="POST" :action="route('posts.repost', [post.profile, post])">
        <div class="flex items-center gap-1">
            <button :class="[
                'hover:text-pixl',
                { 'text-pixl': post.has_reposted }
            ]" aria-label="Re-post">
                <RepeatIcon />
            </button>
            <span :class="[
                { 'text-pixl': post.has_reposted },
                'hover:text-pixl',
                'text-sm'
            ]">
                {{ post.reposts_count }}
            </span>
        </div>
    </Form>

</template>
