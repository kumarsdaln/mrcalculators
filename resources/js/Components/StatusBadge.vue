<script setup>
    defineProps({
        status: String
    })
</script>

<template>
    <span class="
            rounded-full
            px-3
            py-1
            text-xs
            font-bold
            uppercase
        " :class="{
            'bg-green-100 text-green-700':
                status === 'active',

            'bg-red-100 text-red-700':
                status === 'past_due',

            'bg-yellow-100 text-yellow-700':
                status === 'trialing',

            'bg-gray-100 text-gray-700':
                !['active', 'past_due', 'trialing']
                    .includes(status)
        }">
        {{ status }}
    </span>
</template>