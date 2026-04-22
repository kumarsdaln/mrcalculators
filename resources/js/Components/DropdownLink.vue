<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    href: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Link
        :href="href"
        class="block w-full px-4 py-2 text-start text-sm font-medium leading-5 text-[#131747] transition duration-150 ease-in-out hover:bg-[#FF4040]/10 hover:text-[#131747] focus:bg-[#FF4040]/10 focus:outline-none"
    >
        <slot />
    </Link>
</template>
