<script setup>
defineProps({
    type: {
        type: String,
        default: 'button',
    },
});
</script>

<template>
    <button
        :type="type"
        class="inline-flex items-center justify-center rounded-xl border border-[#FF4040] bg-[#FF4040] px-4 py-3 text-xs font-semibold uppercase tracking-[0.24em] text-white shadow-lg shadow-[#FF4040]/20 transition duration-200 hover:bg-[#e23535] focus:outline-none focus:ring-2 focus:ring-[#FF4040]/40 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-60"
    >
        <slot />
    </button>
</template>
