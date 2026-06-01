<script setup>
    defineProps({
        tips: {
            type: Array,
            default: () => []
        }
    });
</script>

<template>
    <div class="bg-white rounded-[2rem] border border-[#131747]/10 p-8">
        <h3 class="text-xl font-bold text-[#131747] mb-6">
            Pro Tips
        </h3>

        <ul class="space-y-3">
            <li v-for="tip in tips" :key="tip" class="flex gap-3">
                <span class="text-[#FF4040]">•</span>
                <span>{{ tip }}</span>
            </li>
        </ul>
    </div>
</template>