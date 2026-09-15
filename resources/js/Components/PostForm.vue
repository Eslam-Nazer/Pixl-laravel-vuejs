<script setup>
import ImageIcon from "@/Components/Icons/ImageIcon.vue";
import VideoIcon from "@/Components/Icons/VideoIcon.vue";

defineProps({
    profile: Object
});
</script>

<template>

    <div
        class="border-pixl-light/10 mt-8 flex items-start gap-4 border-b pb-4"
    >
        <a class="shrink-0" :href="route('profiles.show', { handle: profile.handle })">
            <img
                class="size-10 object-cover"
                :src="profile.avatar_url"
                :alt="`Avatar for ${profile.display_name }`"
            />
        </a>

        <form class="grow" method="POST" :action="route('posts.store')">
            <label class="sr-only" for="content">Post body</label>
            <textarea
                class="w-full resize-none text-lg"
                name="content"
                id="content"
                :placeholder="`What's up ${profile.handle} ?`"
            ></textarea>
            <div class="flex items-center justify-between gap-4">
                <div class="flex gap-4">
                    <button type="button">
                        <ImageIcon/>
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
        </form>

    </div>

</template>
