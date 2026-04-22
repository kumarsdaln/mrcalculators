<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
    },
});

const classes = computed(() =>
    props.active
        ? 'inline-flex items-center border-b-2 border-[#FF4040] px-1 py-5 text-sm font-semibold leading-5 text-[#131747] focus:outline-none transition duration-150 ease-in-out'
        : 'inline-flex items-center border-b-2 border-transparent px-1 py-5 text-sm font-medium leading-5 text-[#131747]/65 hover:border-[#FF4040]/50 hover:text-[#131747] focus:outline-none focus:border-[#FF4040]/50 focus:text-[#131747] transition duration-150 ease-in-out',
);
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
