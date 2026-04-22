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
        ? 'block w-full border-l-4 border-[#FF4040] bg-[#FF4040]/6 py-3 ps-4 pe-4 text-start text-base font-semibold text-[#131747] focus:outline-none transition duration-150 ease-in-out'
        : 'block w-full border-l-4 border-transparent py-3 ps-4 pe-4 text-start text-base font-medium text-[#131747]/70 hover:border-[#131747]/10 hover:bg-[#131747]/5 hover:text-[#131747] focus:outline-none focus:border-[#131747]/10 focus:bg-[#131747]/5 focus:text-[#131747] transition duration-150 ease-in-out',
);
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
