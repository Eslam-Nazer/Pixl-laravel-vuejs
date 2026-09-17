<script setup>
import Navigation from "@/Components/Navigation.vue";
import Aside from "@/Components/Aside.vue";
import FlashMessage from "../Components/FlashMessage.vue";
</script>
<template>
    <div
        class="bg-pixl-dark text-pixl-light flex gap-8 not-sm:px-4 sm:h-dvh sm:overflow-clip sm:pl-4 lg:px-4 xl:gap-16"
    >
        <Navigation />
        <slot />
        <Aside />
    </div>

    <!-- Flash -->
    <FlashMessage />
</template>
