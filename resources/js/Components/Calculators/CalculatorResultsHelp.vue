<script setup>
defineProps({
    title: {
        type: String,
        default: 'Understanding Your Results'
    },

    items: {
        type: Array,
        default: () => []
    }
});
</script>

<template>
    <div class="bg-white rounded-[2rem] border border-[#131747]/10 p-8">
        <h3 class="text-xl font-bold text-[#131747] mb-6">
            {{ title }}
        </h3>

        <div class="grid md:grid-cols-2 gap-6">
            <div
                v-for="item in items"
                :key="item.title"
                class="p-5 rounded-xl bg-[#131747]/5"
            >
                <h4 class="font-semibold text-[#131747]">
                    {{ item.title }}
                </h4>

                <p class="text-sm text-[#131747]/70 mt-2">
                    {{ item.description }}
                </p>
            </div>
        </div>
    </div>
</template>