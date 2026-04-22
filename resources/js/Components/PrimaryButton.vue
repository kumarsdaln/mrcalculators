<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
    },
});
</script>

<template>
    <button
        :type="type"
        class="inline-flex items-center justify-center rounded-xl border border-[#131747] bg-[#131747] px-4 py-3 text-xs font-semibold uppercase tracking-[0.24em] text-white shadow-lg shadow-[#131747]/10 transition duration-200 hover:border-[#FF4040] hover:bg-[#FF4040] focus:outline-none focus:ring-2 focus:ring-[#FF4040]/40 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-60"
    >
        <slot />
    </button>
</template>
