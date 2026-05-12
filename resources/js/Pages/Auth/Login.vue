<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { LockKeyhole, Mail, ArrowRight } from 'lucide-vue-next';

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

        <!-- Header Section -->
        <div class="mb-10 text-center sm:text-left">
            <div class="mb-4 inline-flex items-center gap-2 rounded-full bg-[#FF4040]/10 px-3 py-1">
                <span class="relative flex h-2 w-2">
                    <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-[#FF4040] opacity-75"></span>
                    <span class="relative inline-flex h-2 w-2 rounded-full bg-[#FF4040]"></span>
                </span>
                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-[#FF4040]">
                    Secure Access
                </p>
            </div>
            
            <h1 class="text-3xl font-extrabold tracking-tight text-[#131747] sm:text-4xl">
                Welcome back
            </h1>
            <p class="mt-3 text-sm leading-relaxed text-[#131747]/60">
                Sign in to manage your 
                <span class="font-semibold text-[#131747]">MR Calculators</span> 
                workspace and finance tools.
            </p>
        </div>

        <!-- Session Status -->
        <div
            v-if="status"
            class="mb-6 flex items-center gap-3 rounded-2xl border border-emerald-500/20 bg-emerald-50/50 px-4 py-3 text-sm font-medium text-emerald-700"
        >
            <div class="h-1.5 w-1.5 rounded-full bg-emerald-500"></div>
            {{ status }}
        </div>

        <form @submit.prevent="submit" class="space-y-6">
            <!-- Email Field -->
            <div class="group">
                <InputLabel for="email" value="Email Address" class="mb-1.5 ml-1 text-[#131747]/70" />
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 text-[#131747]/30 transition-colors group-focus-within:text-[#FF4040]">
                        <Mail :size="18" />
                    </div>
                    <TextInput
                        id="email"
                        type="email"
                        class="block w-full border-[#131747]/10 pl-11 transition-all focus:border-[#FF4040]/30 focus:ring-[#FF4040]/5"
                        v-model="form.email"
                        required
                        autofocus
                        placeholder="name@company.com"
                        autocomplete="username"
                    />
                </div>
                <InputError class="mt-2 text-xs" :message="form.errors.email" />
            </div>

            <!-- Password Field -->
            <div class="group">
                <div class="flex items-center justify-between px-1">
                    <InputLabel for="password" value="Password" class="mb-1.5 text-[#131747]/70" />
                    <Link
                        v-if="canResetPassword"
                        :href="route('password.request')"
                        class="text-xs font-semibold text-[#131747]/40 transition hover:text-[#FF4040]"
                    >
                        Forgot?
                    </Link>
                </div>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 text-[#131747]/30 transition-colors group-focus-within:text-[#FF4040]">
                        <LockKeyhole :size="18" />
                    </div>
                    <TextInput
                        id="password"
                        type="password"
                        class="block w-full border-[#131747]/10 pl-11 transition-all focus:border-[#FF4040]/30 focus:ring-[#FF4040]/5"
                        v-model="form.password"
                        required
                        placeholder="••••••••"
                        autocomplete="current-password"
                    />
                </div>
                <InputError class="mt-2 text-xs" :message="form.errors.password" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between px-1">
                <label class="flex cursor-pointer items-center group">
                    <Checkbox name="remember" v-model:checked="form.remember" class="w-6 h-6 rounded-full border-[#131747]/20 text-[#FF4040] focus:ring-[#FF4040]" />
                    <span class="ms-2 text-xs font-medium text-[#131747]/60 group-hover:text-[#131747] transition-colors">Keep me signed in</span>
                </label>
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
                <PrimaryButton 
                    class="group relative flex w-full items-center justify-center overflow-hidden py-4 transition-all hover:bg-[#131747] active:scale-[0.98]" 
                    :class="{ 'opacity-70 cursor-not-allowed': form.processing }" 
                    :disabled="form.processing"
                >
                    <span class="relative z-10 flex items-center gap-2 text-sm font-bold tracking-wide">
                        Log in to Dashboard
                        <ArrowRight :size="16" class="transition-transform group-hover:translate-x-1" />
                    </span>
                </PrimaryButton>
            </div>

            <!-- Secondary Actions -->
            <div class="mt-8 rounded-2xl bg-gray-50/80 p-5 text-center">
                <p class="text-xs text-[#131747]/50">
                    Don't have an account yet? 
                    <Link
                        :href="route('register')"
                        class="ml-1 font-bold text-[#131747] transition hover:text-[#FF4040] hover:underline underline-offset-4"
                    >
                        Get started for free
                    </Link>
                </p>
            </div>
        </form>
    </GuestLayout>
</template>

<style scoped>
/* Optional: Soften the TextInput look if your component doesn't already */
:deep(input) {
    border-radius: 1rem !important;
    padding-top: 0.75rem !important;
    padding-bottom: 0.75rem !important;
}

:deep(button) {
    border-radius: 1rem !important;
}
</style>