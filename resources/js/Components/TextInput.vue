<script setup>
import { onMounted, ref } from 'vue';

const model = defineModel({
    type: String,
    required: true,
});

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input
        class="rounded-xl border border-[#131747]/12 bg-white px-4 py-3 text-sm text-[#131747] shadow-sm shadow-[#131747]/5 transition duration-200 placeholder:text-[#131747]/35 focus:border-[#FF4040]/40 focus:ring-2 focus:ring-[#FF4040]/15"
        v-model="model"
        ref="input"
    />
</template>
