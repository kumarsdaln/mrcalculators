<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

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
        <Head title="Register" />

        <div class="mb-8 space-y-3">
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-[#FF4040]">
                Create account
            </p>
            <h1 class="text-3xl font-bold leading-tight text-[#131747]">
                Set up your finance workspace
            </h1>
            <p class="text-sm leading-6 text-[#131747]/70">
                Create a secure account to unlock subscription billing, calculator access, and a better profile and team setup.
            </p>
        </div>

        <form @submit.prevent="submit" class="space-y-5">
            <div class="grid gap-5 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <InputLabel for="name" value="Full Name" />

                    <TextInput
                        id="name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.name"
                        required
                        autofocus
                        autocomplete="name"
                        placeholder="Alex Morgan"
                    />

                    <InputError class="mt-2" :message="form.errors.name" />
                </div>

                <div>
                    <InputLabel for="company_name" value="Company" />

                    <TextInput
                        id="company_name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.company_name"
                        autocomplete="organization"
                        placeholder="MR Calculators Labs"
                    />

                    <InputError class="mt-2" :message="form.errors.company_name" />
                </div>

                <div>
                    <InputLabel for="phone" value="Phone" />

                    <TextInput
                        id="phone"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.phone"
                        autocomplete="tel"
                        placeholder="+1 555 010 1000"
                    />

                    <InputError class="mt-2" :message="form.errors.phone" />
                </div>

                <div class="sm:col-span-2">
                    <InputLabel for="email" value="Work Email" />

                    <TextInput
                        id="email"
                        type="email"
                        class="mt-1 block w-full"
                        v-model="form.email"
                        required
                        autocomplete="username"
                        placeholder="you@company.com"
                    />

                    <InputError class="mt-2" :message="form.errors.email" />
                </div>
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <InputLabel for="password" value="Password" />

                    <TextInput
                        id="password"
                        type="password"
                        class="mt-1 block w-full"
                        v-model="form.password"
                        required
                        autocomplete="new-password"
                        placeholder="Create a strong password"
                    />

                    <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <div>
                    <InputLabel
                        for="password_confirmation"
                        value="Confirm Password"
                    />

                    <TextInput
                        id="password_confirmation"
                        type="password"
                        class="mt-1 block w-full"
                        v-model="form.password_confirmation"
                        required
                        autocomplete="new-password"
                        placeholder="Repeat your password"
                    />

                    <InputError
                        class="mt-2"
                        :message="form.errors.password_confirmation"
                    />
                </div>
            </div>

            <div class="pt-2">
                <PrimaryButton class="w-full" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Create Account
                </PrimaryButton>
            </div>

            <div class="border-t border-[#131747]/10 pt-5 text-sm">
                <Link
                    :href="route('login')"
                    class="font-medium text-[#131747] transition hover:text-[#FF4040]"
                >
                    Already registered? Sign in
                </Link>
            </div>
        </form>
    </GuestLayout>
</template>
