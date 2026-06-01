<script setup>
    defineProps({
        title: {
            type: String,
            default: 'How to Use This Calculator'
        },

        steps: {
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

        <div class="space-y-6">
            <div v-for="(step, index) in steps" :key="index" class="flex gap-4">
                <div
                    class="w-8 h-8 rounded-full bg-[#131747] text-white flex items-center justify-center text-sm font-bold shrink-0">
                    {{ index + 1 }}
                </div>

                <div>
                    <h4 class="font-semibold text-[#131747]">
                        {{ step.title }}
                    </h4>

                    <p class="text-sm text-[#131747]/70 mt-1">
                        {{ step.description }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>