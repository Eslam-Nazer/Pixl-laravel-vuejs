<script setup>
import RepeatIcon from "@/Components/Icons/RepeatIcon.vue";

defineProps({
    active: {type: Boolean, default: false},
    count: {type: Number, default: 0},
});
</script>

<template>
    <div class="flex items-center gap-1">
        <button
            :class="[
                'hover:text-pixl',
                {'text-pixl': active}
            ]"
            aria-label="Re-post"
        >
            <RepeatIcon />
        </button>
        <span
            :class="[
                {'text-pixl': active},
                'hover:text-pixl',
                'text-sm'
            ]"
        >
        {{ count }}
        </span>
    </div>

</template>
