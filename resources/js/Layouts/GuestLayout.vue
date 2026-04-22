<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();
const flash = computed(() => page.props.flash ?? {});
</script>

<template>
    <div class="relative min-h-screen overflow-hidden bg-[linear-gradient(160deg,#ffffff_0%,#fff5f5_45%,#f7f8ff_100%)]">
        <div class="absolute left-0 top-0 h-72 w-72 rounded-full bg-[#FF4040]/10 blur-3xl"></div>
        <div class="absolute bottom-0 right-0 h-80 w-80 rounded-full bg-[#131747]/10 blur-3xl"></div>

        <div class="relative mx-auto flex min-h-screen max-w-7xl items-center px-4 py-8 sm:px-6 lg:px-8">
            <div class="grid w-full gap-8 lg:grid-cols-[1.1fr,0.9fr]">
                <div class="hidden rounded-[2rem] bg-[#131747] p-10 text-white shadow-[0_30px_90px_-35px_rgba(19,23,71,0.85)] lg:flex lg:flex-col lg:justify-between">
                    <div class="space-y-8">
                        <Link href="/" class="inline-flex items-center gap-3">
                            <ApplicationLogo class="max-h-12 w-12" />
                        </Link>

                        <div class="space-y-4">
                            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-[#FF4040]">
                                Subscription-ready workspace
                            </p>
                            <h1 class="max-w-lg text-4xl font-bold leading-tight">
                                Run calculators, billing, and admin operations from one clean cockpit.
                            </h1>
                            <p class="max-w-lg text-base leading-7 text-white/70">
                                MR Calculators brings forecasting, break-even analysis, secure account management, and Stripe-powered subscriptions into one controlled experience.
                            </p>
                        </div>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-3">
                        <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                            <p class="text-sm font-semibold">Predictive calculators</p>
                            <p class="mt-2 text-sm text-white/60">Forecasting, quota planning, and scenario analysis.</p>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                            <p class="text-sm font-semibold">Stripe billing</p>
                            <p class="mt-2 text-sm text-white/60">Checkout, billing portal, invoices, and trials.</p>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                            <p class="text-sm font-semibold">Admin controls</p>
                            <p class="mt-2 text-sm text-white/60">Users, plans, access levels, and subscription oversight.</p>
                        </div>
                    </div>
                </div>

                <div class="flex items-center">
                    <div class="w-full rounded-[2rem] border border-[#131747]/10 bg-white p-6 shadow-[0_30px_80px_-35px_rgba(19,23,71,0.35)] sm:p-8">
                        <div class="mb-8 flex items-center gap-3 lg:hidden">
                            <Link href="/">
                                <ApplicationLogo class="h-12 w-12" />
                            </Link>
                            <div>
                                <p class="text-base font-semibold text-[#131747]">MR Calculators</p>
                                <p class="text-sm text-[#131747]/60">Finance operating system</p>
                            </div>
                        </div>

                        <div
                            v-if="flash.success || flash.error"
                            class="mb-6 space-y-3"
                        >
                            <div
                                v-if="flash.success"
                                class="rounded-2xl border border-[#131747]/10 bg-[#131747]/5 px-4 py-3 text-sm font-medium text-[#131747]"
                            >
                                {{ flash.success }}
                            </div>
                            <div
                                v-if="flash.error"
                                class="rounded-2xl border border-[#FF4040]/20 bg-[#FF4040]/8 px-4 py-3 text-sm font-medium text-[#FF4040]"
                            >
                                {{ flash.error }}
                            </div>
                        </div>

                        <slot />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
