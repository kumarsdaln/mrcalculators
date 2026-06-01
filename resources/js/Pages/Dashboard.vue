<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head, Link } from '@inertiajs/vue3';
    import calculatorData from '@/data/calculators.json';
    import CalculatorCard from '@/Components/Calculators/CalculatorCard.vue';
    import { useSubscription } from '@/Composable/useSubscription';

    const calculators = calculatorData.calculators;
    import {
        Target,
        Calculator,
        TrendingUp,
        Zap,
        BarChart,
        ShieldCheck,
        CreditCard,
    } from 'lucide-vue-next';

    const icons = {
        Target,
        Calculator,
        TrendingUp,
        Zap,
        BarChart,
    };

    const {
        canAccess,
        getCalculatorRoute,
        subscription
    } = useSubscription();
</script>

<template>

    <Head title="Financial Command Center" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">

                <div>
                    <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-[#FF4040]">
                        Business Growth Tools
                    </p>

                    <h2 class="mt-2 text-3xl font-extrabold tracking-tight text-[#131747]">
                        Financial <span class="text-[#131747]/40">Calculators</span>
                    </h2>

                    <p class="mt-2 text-sm text-[#131747]/60">
                        Plan, forecast, and make smarter business decisions.
                    </p>
                </div>

                <Link :href="route('billing.index')"
                    class="inline-flex items-center gap-2 rounded-xl border border-[#131747]/10 bg-white px-5 py-2.5 text-sm font-bold text-[#131747] shadow-sm transition-all hover:border-[#131747] hover:bg-[#131747] hover:text-white">
                    <CreditCard class="w-4 h-4" />
                    View Plans
                </Link>

            </div>
        </template>

        <div class="py-10">
            <div class="space-y-8">

                <!-- Hero: Access Status -->
                <div
                    class="relative overflow-hidden rounded-[2.5rem] border border-[#131747] bg-[#131747] p-8 text-white shadow-2xl md:p-12">
                    <div
                        class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(255,64,64,0.25),_transparent_40%)]">
                    </div>

                    <div class="relative z-10 grid gap-10 lg:grid-cols-2 lg:items-center">

                        <!-- Left -->
                        <div>

                            <div
                                class="mb-6 inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-4 py-1.5 text-[10px] font-black uppercase tracking-widest">

                                {{
                                    subscription.has_active_subscription
                                        ? 'Premium Access'
                                        : 'Free Access'
                                }}
                            </div>

                            <h1 class="text-4xl font-extrabold leading-tight tracking-tight md:text-5xl">
                                Financial Calculators
                                <br />

                                <span class="text-white/60">
                                    Built for Real Business Decisions
                                </span>
                            </h1>

                            <p class="mt-6 max-w-xl text-lg leading-relaxed text-white/70">
                                Calculate sales goals, forecast future revenue, set profitable
                                pricing, and make smarter business decisions with confidence.
                                Simple tools. Clear answers.
                            </p>

                            <div class="mt-8 flex flex-wrap gap-3">
                                <div class="rounded-full bg-white/10 px-4 py-2 text-sm font-medium">
                                    Sales Planning
                                </div>

                                <div class="rounded-full bg-white/10 px-4 py-2 text-sm font-medium">
                                    Pricing Strategy
                                </div>

                                <div class="rounded-full bg-white/10 px-4 py-2 text-sm font-medium">
                                    Revenue Forecasting
                                </div>
                            </div>

                        </div>

                        <!-- Right -->
                        <div class="rounded-3xl border border-white/10 bg-white/5 p-8 backdrop-blur-md">

                            <div class="flex items-center justify-between border-b border-white/10 pb-6">
                                <div>
                                    <p class="text-[10px] font-bold uppercase tracking-widest text-white/40">
                                        Current Plan
                                    </p>

                                    <h3 class="mt-1 text-2xl font-black">
                                        {{ subscription.plan_name }}
                                    </h3>
                                </div>

                                <ShieldCheck class="h-10 w-10 text-[#FF4040]" />
                            </div>

                            <div class="mt-6 space-y-4">

                                <div class="flex items-center justify-between rounded-xl bg-white/5 p-4">
                                    <span class="text-white/70">
                                        Available Calculators
                                    </span>

                                    <span class="font-bold">
                                        {{ (subscription.feature_access || []).length }}
                                    </span>
                                </div>

                                <div class="flex items-center justify-between rounded-xl bg-white/5 p-4">
                                    <span class="text-white/70">
                                        Account Status
                                    </span>

                                    <span class="font-bold text-green-400">
                                        Active
                                    </span>
                                </div>

                            </div>

                            <Link :href="route('billing.index')"
                                class="mt-6 block rounded-xl bg-[#FF4040] px-6 py-4 text-center text-sm font-black uppercase tracking-widest text-white transition hover:bg-[#e23535]">
                                View Plans
                            </Link>

                        </div>

                    </div>
                </div>

                <!-- Tools Grid -->
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    <CalculatorCard v-for="tool in calculators" :key="tool.slug" :calculator="tool"
                        :icon="icons[tool.icon]" :has-access="canAccess(tool.slug)" :href="getCalculatorRoute(tool)" />
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
