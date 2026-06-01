<script setup>
    import { Clock3, Sparkles } from 'lucide-vue-next';

    defineProps({
        calculator: {
            type: Object,
            required: true,
        },
    });
</script>

<template>
    <div class="relative overflow-hidden rounded-[2rem] border border-[#131747]/10 bg-white p-8 md:p-10 shadow-sm">
        <!-- Background Effect -->
        <div class="absolute top-0 right-0 h-64 w-64 rounded-full bg-[#FF4040]/5 blur-3xl" />

        <div class="relative z-10">
            <!-- Top Meta -->
            <div class="flex flex-wrap items-center gap-3 mb-6">
                <span v-if="calculator.category"
                    class="inline-flex items-center rounded-full bg-[#131747]/5 px-4 py-1.5 text-xs font-bold uppercase tracking-widest text-[#131747]">
                    {{ calculator.category }}
                </span>

                <span v-if="calculator.badge"
                    class="inline-flex items-center rounded-full bg-[#FF4040]/10 px-4 py-1.5 text-xs font-bold uppercase tracking-widest text-[#FF4040]">
                    <Sparkles class="w-3 h-3 mr-1" />
                    {{ calculator.badge }}
                </span>

                <span v-if="calculator.time_to_complete"
                    class="inline-flex items-center rounded-full bg-gray-100 px-4 py-1.5 text-xs font-semibold text-gray-600">
                    <Clock3 class="w-3 h-3 mr-1" />
                    {{ calculator.time_to_complete }}
                </span>
            </div>

            <!-- Title -->
            <h1 class="text-3xl md:text-5xl font-black tracking-tight text-[#131747]">
                {{ calculator.title }}
            </h1>

            <!-- Subtitle -->
            <p v-if="calculator.subtitle" class="mt-3 text-lg font-medium text-[#FF4040]">
                {{ calculator.subtitle }}
            </p>

            <!-- Description -->
            <p class="mt-6 max-w-4xl text-base md:text-lg leading-relaxed text-[#131747]/70">
                {{ calculator.description }}
            </p>

            <!-- Benefits -->
            <div v-if="calculator.benefits?.length" class="grid gap-3 mt-8 md:grid-cols-3">
                <div v-for="benefit in calculator.benefits" :key="benefit"
                    class="flex items-center gap-3 rounded-xl bg-[#131747]/5 p-4">
                    <div class="h-2 w-2 rounded-full bg-[#FF4040]" />

                    <span class="text-sm font-medium text-[#131747]">
                        {{ benefit }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>