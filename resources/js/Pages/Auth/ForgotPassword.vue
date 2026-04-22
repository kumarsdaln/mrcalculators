<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <GuestLayout>
        <Head title="Forgot Password" />

        <div class="mb-8 space-y-3">
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-[#FF4040]">
                Password recovery
            </p>
            <h1 class="text-3xl font-bold leading-tight text-[#131747]">
                Reset your account password
            </h1>
            <p class="text-sm leading-6 text-[#131747]/70">
                Enter the email tied to your account and we’ll send a secure reset link so you can get back into MR Calculators quickly.
            </p>
        </div>

        <div
            v-if="status"
            class="mb-6 rounded-2xl border border-[#131747]/10 bg-[#131747]/5 px-4 py-3 text-sm font-medium text-[#131747]"
        >
            {{ status }}
        </div>

        <form @submit.prevent="submit" class="space-y-5">
            <div>
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="you@company.com"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="pt-2">
                <PrimaryButton class="w-full" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Email Password Reset Link
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
