<script setup>
import ImageIcon from "@/Components/Icons/ImageIcon.vue";
import VideoIcon from "@/Components/Icons/VideoIcon.vue";
import { Form } from "@inertiajs/vue3";
import { route } from "ziggy-js";

defineProps({
    profile: Object
});
</script>

<template>

    <div class="border-pixl-light/10 mt-8 flex items-start gap-4 border-b pb-4">
        <a class="shrink-0" :href="route('profiles.show', { handle: profile.handle })">
            <img class="size-10 object-cover" :src="profile.avatar_url" :alt="`Avatar for ${profile.display_name}`" />
        </a>

        <Form class="grow" method="POST" :action="route('posts.store')" reset-on-success #default="{ errors }">
            <label class="sr-only" for="content">Post body</label>
            <textarea class="w-full resize-none text-lg" name="content" id="content"
                :placeholder="`What's up ${profile.handle} ?`" />

            <div class="text-xs text-red-500 mb-3" v-if="errors.content" v-text="errors.content" />
            <div class="flex items-center justify-between gap-4">
                <div class="flex gap-4">
                    <button type="button">
                        <ImageIcon />
                    </button>
                    <button type="button">
                        <VideoIcon />
                    </button>
                </div>
                <button class="bg-pixl hover:bg-pixl/90 text-pixl-dark border-transparent px-4 py-1 transition-colors"
                    type="submit">
                    Post
                </button>
            </div>
        </Form>

    </div>
</template>
