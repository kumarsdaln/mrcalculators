<script setup>
    defineProps({
        links: {
            type: Array,
            default: () => []
        }
    })
</script>

<template>
    <div class="flex flex-wrap items-center gap-2">
        <template v-for="link in links" :key="link.label">

            <span v-if="!link.url" class="
                    rounded-lg
                    border
                    border-[#131747]/10
                    px-3
                    py-2
                    text-sm
                    text-[#131747]/30
                " v-html="link.label" />

            <Link v-else :href="link.url" preserve-scroll class="
                    rounded-lg
                    border
                    border-[#131747]/10
                    px-3
                    py-2
                    text-sm
                    transition
                " :class="link.active
                        ? 'bg-[#131747] text-white border-[#131747]'
                        : 'text-[#131747] hover:bg-[#131747]/5'
                    " v-html="link.label" />

        </template>
    </div>
</template>