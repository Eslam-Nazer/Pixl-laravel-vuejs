<script setup>
import CommentIcon from "@/Components/Icons/CommentIcon.vue";

defineProps({
    count: {type: Number, default: 0},
});
</script>

<template>
    <div class="flex items-center gap-1">
        <button class="hover:text-pixl" aria-label="Comment">
            <CommentIcon />
        </button>
        <span class="text-sm">{{ count }}</span>
    </div>

</template>
