<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { 
    User, 
    Building2, 
    Phone, 
    Mail, 
    KeyRound, 
    ShieldCheck, 
    ArrowRight 
} from 'lucide-vue-next';

const form = useForm({
    name: '',
    company_name: '',
    phone: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Create Workspace" />

        <!-- Header Section -->
        <div class="mb-10">
            <div class="mb-4 inline-flex items-center gap-2 rounded-full bg-[#131747]/5 px-3 py-1">
                <ShieldCheck :size="14" class="text-[#131747]/60" />
                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-[#131747]/60">
                    Enterprise-Grade Security
                </p>
            </div>
            
            <h1 class="text-3xl font-extrabold tracking-tight text-[#131747] sm:text-4xl">
                Set up your workspace
            </h1>
            <p class="mt-3 text-sm leading-relaxed text-[#131747]/60">
                Join MR Calculators to unlock professional finance tools and team audit history.
            </p>
        </div>

        <form @submit.prevent="submit" class="space-y-6">
            <!-- Section 1: Identity -->
            <div class="space-y-5">
                <div class="group">
                    <InputLabel for="name" value="Full Name" class="mb-1.5 ml-1 text-[#131747]/70" />
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 text-[#131747]/30 group-focus-within:text-[#FF4040] transition-colors">
                            <User :size="18" />
                        </div>
                        <TextInput
                            id="name"
                            type="text"
                            class="block w-full border-[#131747]/10 pl-11 transition-all focus:border-[#FF4040]/30 focus:ring-[#FF4040]/5"
                            v-model="form.name"
                            required
                            autofocus
                            placeholder="Alex Morgan"
                        />
                    </div>
                    <InputError class="mt-2 text-xs" :message="form.errors.name" />
                </div>

                <div class="grid gap-5 sm:grid-cols-2">
                    <div class="group">
                        <InputLabel for="company_name" value="Company" class="mb-1.5 ml-1 text-[#131747]/70" />
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-4 text-[#131747]/30 group-focus-within:text-[#FF4040] transition-colors">
                                <Building2 :size="18" />
                            </div>
                            <TextInput
                                id="company_name"
                                type="text"
                                class="block w-full border-[#131747]/10 pl-11 transition-all focus:border-[#FF4040]/30 focus:ring-[#FF4040]/5"
                                v-model="form.company_name"
                                placeholder="Acme Corp"
                            />
                        </div>
                    </div>

                    <div class="group">
                        <InputLabel for="phone" value="Phone Number" class="mb-1.5 ml-1 text-[#131747]/70" />
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-4 text-[#131747]/30 group-focus-within:text-[#FF4040] transition-colors">
                                <Phone :size="18" />
                            </div>
                            <TextInput
                                id="phone"
                                type="text"
                                class="block w-full border-[#131747]/10 pl-11 transition-all focus:border-[#FF4040]/30 focus:ring-[#FF4040]/5"
                                v-model="form.phone"
                                placeholder="+1 (555) 000-0000"
                            />
                        </div>
                    </div>
                </div>

                <div class="group">
                    <InputLabel for="email" value="Work Email" class="mb-1.5 ml-1 text-[#131747]/70" />
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 text-[#131747]/30 group-focus-within:text-[#FF4040] transition-colors">
                            <Mail :size="18" />
                        </div>
                        <TextInput
                            id="email"
                            type="email"
                            class="block w-full border-[#131747]/10 pl-11 transition-all focus:border-[#FF4040]/30 focus:ring-[#FF4040]/5"
                            v-model="form.email"
                            required
                            placeholder="you@company.com"
                        />
                    </div>
                    <InputError class="mt-2 text-xs" :message="form.errors.email" />
                </div>
            </div>

            <!-- Section 2: Security -->
            <div class="rounded-3xl bg-gray-50/50 p-6 space-y-5 border border-[#131747]/5">
                <p class="text-[10px] font-black uppercase tracking-widest text-[#131747]/40 mb-4 px-1">Security Credentials</p>
                
                <div class="grid gap-5 sm:grid-cols-2">
                    <div class="group">
                        <InputLabel for="password" value="Password" class="mb-1.5 ml-1 text-[#131747]/70" />
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-4 text-[#131747]/30 group-focus-within:text-[#FF4040] transition-colors">
                                <KeyRound :size="18" />
                            </div>
                            <TextInput
                                id="password"
                                type="password"
                                class="block w-full border-[#131747]/10 pl-11 transition-all focus:border-[#FF4040]/30 focus:ring-[#FF4040]/5"
                                v-model="form.password"
                                required
                                placeholder="••••••••"
                            />
                        </div>
                        <InputError class="mt-2 text-xs" :message="form.errors.password" />
                    </div>

                    <div class="group">
                        <InputLabel for="password_confirmation" value="Confirm" class="mb-1.5 ml-1 text-[#131747]/70" />
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-4 text-[#131747]/30 group-focus-within:text-[#FF4040] transition-colors">
                                <ShieldCheck :size="18" />
                            </div>
                            <TextInput
                                id="password_confirmation"
                                type="password"
                                class="block w-full border-[#131747]/10 pl-11 transition-all focus:border-[#FF4040]/30 focus:ring-[#FF4040]/5"
                                v-model="form.password_confirmation"
                                required
                                placeholder="••••••••"
                            />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Area -->
            <div class="pt-4 space-y-6">
                <PrimaryButton 
                    class="group relative flex w-full items-center justify-center overflow-hidden py-4 transition-all active:scale-[0.98]" 
                    :class="{ 'opacity-70 cursor-not-allowed': form.processing }" 
                    :disabled="form.processing"
                >
                    <span class="relative z-10 flex items-center gap-2 text-sm font-bold tracking-wide">
                        Create Workspace
                        <ArrowRight :size="16" class="transition-transform group-hover:translate-x-1" />
                    </span>
                </PrimaryButton>

                <div class="text-center">
                    <p class="text-xs text-[#131747]/50">
                        Already have an account? 
                        <Link
                            :href="route('login')"
                            class="ml-1 font-bold text-[#131747] transition hover:text-[#FF4040] hover:underline underline-offset-4"
                        >
                            Sign in instead
                        </Link>
                    </p>
                </div>
            </div>
        </form>
    </GuestLayout>
</template>

<style scoped>
:deep(input) {
    border-radius: 1rem !important;
    padding-top: 0.75rem !important;
    padding-bottom: 0.75rem !important;
}

:deep(button) {
    border-radius: 1rem !important;
}
</style>