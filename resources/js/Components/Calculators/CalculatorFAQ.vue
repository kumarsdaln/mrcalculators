<script setup>
    defineProps({
        faqs: {
            type: Array,
            default: () => []
        }
    });
</script>

<template>
    <div class="bg-white rounded-[2rem] border border-[#131747]/10 p-8">
        <h3 class="text-xl font-bold text-[#131747] mb-6">
            Frequently Asked Questions
        </h3>

        <details v-for="faq in faqs" :key="faq.question" class="mb-4 border rounded-xl p-4">
            <summary class="cursor-pointer font-semibold">
                {{ faq.question }}
            </summary>

            <p class="mt-3 text-sm text-[#131747]/70">
                {{ faq.answer }}
            </p>
        </details>
    </div>
</template>