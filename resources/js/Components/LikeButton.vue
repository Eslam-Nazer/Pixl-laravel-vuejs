<script setup>
import HeartIcon from "@/Components/Icons/HeartIcon.vue";

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
                {
                    'text-pixl': active,
                }
            ]"
            aria-label="Like"
        >
            <HeartIcon />
        </button>
        <span
            :class="['hover:text-pixl',{'text-pixl': active}]"
            class="text-sm"
        >
        {{ count }}
        </span>

    </div>

</template>
