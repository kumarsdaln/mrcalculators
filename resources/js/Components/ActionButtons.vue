<script setup>
import { Link } from '@inertiajs/vue3';

    defineProps({
        viewUrl: String,
        editUrl: String,
    })
</script>

<template>
    <div class="
            flex
            justify-end
            gap-2
        ">
        <Link :href="viewUrl" class="
                rounded-lg
                border
                border-[#131747]/10
                px-3
                py-2
                text-xs
                font-bold
                text-[#131747]
            ">
        View
        </Link>

        <Link :href="editUrl" class="
                rounded-lg
                bg-[#131747]
                px-3
                py-2
                text-xs
                font-bold
                text-white
            ">
        Edit
        </Link>

        <slot />
    </div>
</template>