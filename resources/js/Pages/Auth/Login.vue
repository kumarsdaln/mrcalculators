<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />

        <div class="mb-8 space-y-3">
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-[#FF4040]">
                Welcome back
            </p>
            <h1 class="text-3xl font-bold leading-tight text-[#131747]">
                Sign in to your MR Calculators workspace
            </h1>
            <p class="text-sm leading-6 text-[#131747]/70">
                Access your subscription, finance calculators, audit history, and admin controls from one place.
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
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4 block">
                <label class="flex items-center">
                    <Checkbox name="remember" v-model:checked="form.remember" />
                    <span class="ms-2 text-sm text-[#131747]/65">Remember me</span>
                </label>
            </div>

            <div class="pt-2">
                <PrimaryButton class="w-full" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Log in
                </PrimaryButton>
            </div>

            <div class="flex flex-col gap-3 border-t border-[#131747]/10 pt-5 text-sm sm:flex-row sm:items-center sm:justify-between">
                <Link
                    :href="route('register')"
                    class="font-medium text-[#131747] transition hover:text-[#FF4040]"
                >
                    New here? Create an account
                </Link>

                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="font-medium text-[#131747]/65 transition hover:text-[#FF4040]"
                >
                    Forgot your password?
                </Link>
            </div>
        </form>
    </GuestLayout>
</template>
