<script setup>
defineProps({
    columns: Array
})
</script>

<template>
    <thead>
        <tr
            class="
                border-b
                border-[#131747]/10
                bg-[#131747]/[0.02]
            "
        >
            <th
                v-for="column in columns"
                :key="column.key"
                class="
                    px-5
                    py-4
                    text-left
                    text-xs
                    font-bold
                    uppercase
                    tracking-widest
                    text-[#131747]/50
                "
            >
                {{ column.label }}
            </th>
        </tr>
    </thead>
</template>