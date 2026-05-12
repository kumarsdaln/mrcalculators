<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();
const flash = computed(() => page.props.flash ?? {});
</script>

<template>
    <div class="relative min-h-screen overflow-hidden bg-[linear-gradient(160deg,#ffffff_0%,#fff5f5_45%,#f7f8ff_100%)]">
        <!-- Background Blobs -->
        <div class="absolute left-0 top-0 h-72 w-72 rounded-full bg-[#FF4040]/10 blur-3xl"></div>
        <div class="absolute bottom-0 right-0 h-80 w-80 rounded-full bg-[#131747]/10 blur-3xl"></div>

        <div class="relative mx-auto flex min-h-screen max-w-7xl items-center px-4 py-8 sm:px-6 lg:px-8">
            <div class="grid w-full gap-8 lg:grid-cols-[1.1fr,0.9fr]">
                
                <!-- Left Sidebar (Desktop) -->
                <div class="hidden rounded-[2.5rem] bg-[#131747] p-12 text-white shadow-[0_30px_90px_-35px_rgba(19,23,71,0.85)] lg:flex lg:flex-col lg:justify-between">
                    <div class="space-y-10">
                        <!-- Enhanced Desktop Logo -->
                        <Link href="/" class="group inline-flex items-center gap-4">
                            <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-white/10 p-3 transition-all duration-300 group-hover:bg-white/20 group-hover:scale-105">
                                <ApplicationLogo class="h-full w-full object-contain" />
                            </div>
                            <span class="text-xl font-bold tracking-tight">MR Calculators</span>
                        </Link>

                        <div class="space-y-6">
                            <p class="text-xs font-bold uppercase tracking-[0.4em] text-[#FF4040]">
                                Subscription-ready workspace
                            </p>
                            <h1 class="max-w-lg text-5xl font-extrabold leading-[1.1] tracking-tight">
                                Run operations from one <span class="text-[#FF4040]">clean cockpit.</span>
                            </h1>
                            <p class="max-w-md text-lg leading-relaxed text-white/60">
                                Forecasting, break-even analysis, and Stripe-powered subscriptions into one controlled experience.
                            </p>
                        </div>
                    </div>

                    <!-- Feature Grid -->
                    <div class="grid gap-4 sm:grid-cols-3">
                        <div class="rounded-2xl border border-white/10 bg-white/5 p-5 backdrop-blur-sm">
                            <p class="text-sm font-bold">Predictive</p>
                            <p class="mt-1 text-xs text-white/50">Forecasting & Quota planning.</p>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/5 p-5 backdrop-blur-sm">
                            <p class="text-sm font-bold">Stripe Billing</p>
                            <p class="mt-1 text-xs text-white/50">Invoices, trials & checkout.</p>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/5 p-5 backdrop-blur-sm">
                            <p class="text-sm font-bold">Admin</p>
                            <p class="mt-1 text-xs text-white/50">Full subscription oversight.</p>
                        </div>
                    </div>
                </div>

                <!-- Right Side (Login/Form Area) -->
                <div class="flex items-center">
                    <div class="w-full rounded-[2.5rem] border border-[#131747]/10 bg-white p-8 shadow-[0_40px_100px_-40px_rgba(19,23,71,0.2)] sm:p-12">
                        
                        <!-- Enhanced Mobile Logo -->
                        <div class="mb-10 flex flex-col items-center text-center lg:hidden">
                            <Link href="/" class="mb-4 flex h-20 w-20 items-center justify-center rounded-3xl bg-[#131747]/5 p-4 shadow-inner">
                                <ApplicationLogo class="h-full w-full object-contain" />
                            </Link>
                            <div>
                                <h2 class="text-2xl font-bold text-[#131747]">MR Calculators</h2>
                                <p class="text-sm font-medium text-[#131747]/50">Finance Operating System</p>
                            </div>
                        </div>

                        <!-- Flash Messages -->
                        <div v-if="flash.success || flash.error" class="mb-8 space-y-3">
                            <div v-if="flash.success" class="rounded-2xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
                                {{ flash.success }}
                            </div>
                            <div v-if="flash.error" class="rounded-2xl border border-red-100 bg-red-50 px-4 py-3 text-sm font-medium text-red-600">
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