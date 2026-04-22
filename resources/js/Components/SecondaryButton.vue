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
        class="inline-flex items-center justify-center rounded-xl border border-[#131747]/15 bg-white px-4 py-3 text-xs font-semibold uppercase tracking-[0.24em] text-[#131747] shadow-sm shadow-[#131747]/5 transition duration-200 hover:border-[#131747]/30 hover:bg-[#131747]/5 focus:outline-none focus:ring-2 focus:ring-[#131747]/15 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-60"
    >
        <slot />
    </button>
</template>
