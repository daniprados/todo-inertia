<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/inertia-vue3';
import App from "@/Layouts/App.vue";
</script>

<template>
    <App>
    <div class=" flex flex-col sm:justify-center items-center pt-3 sm:pt-0 ">
        <div
            class="max-w-md mt-3 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg"
        >
            <slot />
        </div>
    </div>
    </App>
</template>
