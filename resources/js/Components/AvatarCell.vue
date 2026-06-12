<script setup>
    defineProps({
        name: String,
        email: String,
    })
</script>

<template>
    <div class="flex items-center gap-4">

        <div class="
                flex
                h-11
                w-11
                items-center
                justify-center
                rounded-2xl
                bg-[#131747]/5
                font-black
                text-[#131747]
            ">
            {{ name.charAt(0).toUpperCase() }}
        </div>

        <div>
            <p class="
                    font-bold
                    text-[#131747]
                ">
                {{ name }}
            </p>

            <p class="
                    text-sm
                    text-[#131747]/50
                ">
                {{ email }}
            </p>
        </div>

    </div>
</template>