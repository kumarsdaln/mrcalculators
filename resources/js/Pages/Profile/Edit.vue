<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const page = usePage();
const user = computed(() => page.props.auth.user ?? {});
const subscription = computed(() => page.props.auth.subscription ?? {});
</script>

<template>
    <Head title="Profile" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-[#FF4040]">
                        Account settings
                    </p>
                    <h2 class="mt-2 text-2xl font-bold leading-tight text-[#131747]">
                        Profile & Security
                    </h2>
                </div>
                <Link
                    :href="route('billing.index')"
                    class="inline-flex items-center justify-center rounded-2xl border border-[#131747]/10 bg-white px-5 py-3 text-sm font-semibold text-[#131747] shadow-sm shadow-[#131747]/5 transition hover:border-[#FF4040]/30 hover:text-[#FF4040]"
                >
                    Open Billing Center
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
                <div class="overflow-hidden rounded-[2rem] border border-[#131747]/10 bg-white shadow-[0_24px_80px_-32px_rgba(19,23,71,0.35)]">
                    <div class="grid gap-6 p-6 lg:grid-cols-[1.35fr,0.65fr] lg:p-8">
                        <div class="flex items-start gap-4">
                            <div class="flex h-16 w-16 items-center justify-center rounded-full bg-[#131747] text-lg font-bold uppercase tracking-[0.24em] text-white">
                                {{ user.initials }}
                            </div>
                            <div class="space-y-2">
                                <h3 class="text-2xl font-bold text-[#131747]">{{ user.name }}</h3>
                                <p class="text-sm text-[#131747]/65">{{ user.email }}</p>
                                <p v-if="user.company_name" class="text-sm text-[#131747]/55">
                                    {{ user.company_name }}
                                </p>
                            </div>
                        </div>

                        <div class="rounded-[1.5rem] border border-[#131747]/10 bg-[#131747]/5 p-5">
                            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-[#131747]/45">
                                Subscription snapshot
                            </p>
                            <div class="mt-3 flex items-center justify-between gap-3">
                                <div>
                                    <p class="text-lg font-semibold text-[#131747]">
                                        {{ subscription.plan_name }}
                                    </p>
                                    <p class="text-sm text-[#131747]/60">
                                        Status: {{ subscription.status }}
                                    </p>
                                </div>
                                <span class="rounded-full bg-[#FF4040]/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-[#FF4040]">
                                    {{ subscription.interval || 'lifetime' }}
                                </span>
                            </div>
                            <p class="mt-4 text-sm leading-6 text-[#131747]/65">
                                Manage invoices, payment methods, cancellations, and plan changes from the billing center.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="grid gap-6 lg:grid-cols-3">
                    <div class="rounded-[2rem] border border-[#131747]/10 bg-white p-6 shadow-sm shadow-[#131747]/5 lg:col-span-2">
                    <UpdateProfileInformationForm
                        :must-verify-email="mustVerifyEmail"
                        :status="status"
                    />
                    </div>

                    <div class="rounded-[2rem] border border-[#131747]/10 bg-white p-6 shadow-sm shadow-[#131747]/5">
                        <div class="space-y-4">
                            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-[#FF4040]">
                                Billing readiness
                            </p>
                            <h3 class="text-xl font-semibold text-[#131747]">Keep your account invoice-ready</h3>
                            <p class="text-sm leading-6 text-[#131747]/65">
                                Update company, phone, and address details here so checkout, invoices, and future tax settings stay aligned.
                            </p>
                            <div class="space-y-3 rounded-[1.5rem] border border-[#131747]/10 bg-[#131747]/5 p-4 text-sm text-[#131747]/70">
                                <p>Payment method: {{ subscription.payment_method || 'Not connected yet' }}</p>
                                <p v-if="subscription.payment_method_last_four">
                                    Last four: •••• {{ subscription.payment_method_last_four }}
                                </p>
                                <p v-if="subscription.trial_ends_at">
                                    Trial ends: {{ new Date(subscription.trial_ends_at).toLocaleDateString() }}
                                </p>
                            </div>
                            <Link
                                :href="route('billing.index')"
                                class="inline-flex w-full items-center justify-center rounded-2xl border border-[#131747] bg-[#131747] px-5 py-3 text-sm font-semibold text-white transition hover:border-[#FF4040] hover:bg-[#FF4040]"
                            >
                                Manage Subscription
                            </Link>
                        </div>
                    </div>

                    <div class="rounded-[2rem] border border-[#131747]/10 bg-white p-6 shadow-sm shadow-[#131747]/5">
                        <UpdatePasswordForm />
                    </div>

                    <div class="rounded-[2rem] border border-[#131747]/10 bg-white p-6 shadow-sm shadow-[#131747]/5 lg:col-span-2">
                        <DeleteUserForm />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
