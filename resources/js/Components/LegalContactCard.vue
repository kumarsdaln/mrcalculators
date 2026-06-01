<script setup>
    defineProps({
        title: {
            type: String,
            default: 'Questions?'
        },

        description: {
            type: String,
            default: 'If you have questions, please contact our support team.'
        },

        email: {
            type: String,
            default: 'support@mrcalculators.com'
        },

        buttonText: {
            type: String,
            default: 'Contact Support'
        }
    });
</script>

<template>
    <div class="relative overflow-hidden rounded-[2rem] bg-[#131747] p-8 md:p-10 text-white shadow-xl">
        <!-- Background Accent -->
        <div
            class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(255,64,64,0.25),_transparent_40%)]" />

        <div class="relative z-10">
            <h3 class="text-2xl font-black tracking-tight">
                {{ title }}
            </h3>

            <p class="mt-4 max-w-2xl leading-8 text-white/70">
                {{ description }}
            </p>

            <a :href="`mailto:${email}`"
                class="mt-6 inline-flex items-center rounded-xl bg-[#FF4040] px-6 py-3 text-sm font-bold text-white transition-all hover:-translate-y-0.5 hover:bg-[#e23535] hover:shadow-lg hover:shadow-[#FF4040]/20">
                {{ buttonText }}
            </a>
        </div>
    </div>
</template>