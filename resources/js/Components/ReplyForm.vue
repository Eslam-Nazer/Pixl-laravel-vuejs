<script setup>
import ImageIcon from "@/Components/Icons/ImageIcon.vue";
import VideoIcon from "@/Components/Icons/VideoIcon.vue";
import { Form } from "@inertiajs/vue3";

defineProps({
    profile: Object,
    post: Object,
});

let emit = defineEmits(["success"]);
</script>

<template>
    <div
        class="border-pixl-light/10 bg-pixl-light/3 mt-8 flex items-start gap-4 border-t p-4"
        v-if="$page.props.auth.user"
    >
        <a class="shrink-0" :href="route('profiles.show', profile)">
            <img
                class="size-10 object-cover"
                :src="profile.avatar_url"
                :alt="`Avatar for ${profile.display_name}`"
            />
        </a>

        <Form
            class="grow"
            method="POST"
            :action="route('posts.reply', [post.profile, post])"
            reset-on-success
            #default="{ errors }"
            @success="emit('success')"
        >
            <label class="sr-only" for="content">Reply body</label>
            <textarea
                class="w-full resize-none text-lg"
                name="content"
                id="content"
                :placeholder="`Reply to ${post.profile.display_name}'s post`"
                rows="5"
            ></textarea>

            <div
                class="text-xs text-red-500 mb-3"
                v-if="errors.content"
                v-text="errors.content"
            />

            <div class="flex items-center justify-between gap-4">
                <div class="flex gap-4">
                    <button type="button">
                        <ImageIcon />
                    </button>
                    <button type="button">
                        <VideoIcon />
                    </button>
                </div>
                <button
                    class="bg-pixl hover:bg-pixl/90 text-pixl-dark border-transparent px-4 py-1 transition-colors"
                    type="submit"
                >
                    Post
                </button>
            </div>
        </Form>
    </div>
</template>
