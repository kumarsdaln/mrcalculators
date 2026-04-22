<script setup>
import { computed } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    status: {
        type: String,
    },
});

const form = useForm({});

const submit = () => {
    form.post(route('verification.send'));
};

const verificationLinkSent = computed(
    () => props.status === 'verification-link-sent',
);
</script>

<template>
    <GuestLayout>
        <Head title="Email Verification" />

        <div class="mb-8 space-y-3">
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-[#FF4040]">
                Verify your email
            </p>
            <h1 class="text-3xl font-bold leading-tight text-[#131747]">
                Confirm your inbox before you continue
            </h1>
            <p class="text-sm leading-6 text-[#131747]/70">
                We’ve sent a verification link to your email address. Confirm it to finish activating your MR Calculators account.
            </p>
        </div>

        <div
            class="mb-6 rounded-2xl border border-[#131747]/10 bg-[#131747]/5 px-4 py-3 text-sm font-medium text-[#131747]"
            v-if="verificationLinkSent"
        >
            A new verification link has been sent to the email address you
            provided during registration.
        </div>

        <form @submit.prevent="submit">
            <div class="space-y-4">
                <PrimaryButton class="w-full" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Resend Verification Email
                </PrimaryButton>

                <div class="text-center">
                    <Link
                        :href="route('logout')"
                        method="post"
                        as="button"
                        class="text-sm font-medium text-[#131747]/65 transition hover:text-[#FF4040]"
                    >
                        Log Out
                    </Link>
                </div>
            </div>
        </form>
    </GuestLayout>
</template>
