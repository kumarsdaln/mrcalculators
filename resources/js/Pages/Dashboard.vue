<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();
const subscription = computed(() => page.props.auth.subscription ?? {});
const isAdmin = computed(() => page.props.auth.user?.is_admin ?? false);

const tools = [
    {
        slug: 'monthly_sales_goal',
        short: 'MQ',
        title: 'Monthly Quota Isolator',
        description: 'Break annual revenue goals into realistic monthly targets with fast planning math.',
        route: 'calculator.monthly-sales-goal',
        tag: 'Starter',
    },
    {
        slug: 'break_even_price',
        short: 'BE',
        title: 'Break-Even Matrix',
        description: 'Calculate your exact break-even price and target margin thresholds with confidence.',
        route: 'calculator.break-even-and-selling-price',
        tag: 'Starter',
    },
    {
        slug: 'future_sales_forecast',
        short: 'FS',
        title: 'Predictive Sales Forecaster',
        description: 'Project the next sales period using historical performance and linear regression.',
        route: 'calculator.future-sales-forecast',
        tag: 'Growth',
    },
    {
        slug: 'what_if_engine',
        short: 'WI',
        title: 'What-If Scenario Engine',
        description: 'Simulate pricing and cost changes before they affect your actual margins.',
        route: 'calculator.what-if-engine',
        tag: 'Growth',
    },
    {
        slug: 'ltv_cac_ratio',
        short: 'LC',
        title: 'LTV:CAC Health Engine',
        description: 'Compare customer value against acquisition cost to check whether growth is sustainable.',
        route: 'calculator.ltv-cac-ratio',
        tag: 'Scale',
    },
];

const hasFeature = (slug) =>
    isAdmin.value || (subscription.value.feature_access ?? []).includes(slug);
</script>

<template>
    <Head title="Financial Command Center" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-[#FF4040]">
                        Financial operations cockpit
                    </p>
                    <h2 class="mt-2 text-2xl font-bold leading-tight text-[#131747]">
                        Financial Command Center
                    </h2>
                </div>
                <Link
                    :href="route('billing.index')"
                    class="inline-flex items-center justify-center rounded-2xl border border-[#131747]/10 bg-white px-5 py-3 text-sm font-semibold text-[#131747] shadow-sm shadow-[#131747]/5 transition hover:border-[#FF4040]/30 hover:text-[#FF4040]"
                >
                    Manage Billing
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-8 px-4 sm:px-6 lg:px-8">
                <div class="grid gap-8 lg:grid-cols-[1.4fr,0.6fr]">
                    <div class="relative overflow-hidden rounded-[2rem] border border-[#131747] bg-[#131747] p-8 text-white shadow-[0_28px_100px_-40px_rgba(19,23,71,0.85)] md:p-10">
                        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(255,64,64,0.35),_transparent_32%),linear-gradient(135deg,_rgba(255,255,255,0.08),_transparent_55%)]"></div>
                        <div class="relative z-10">
                            <div class="mb-6 inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.24em] text-white">
                                <span class="h-2 w-2 rounded-full bg-[#FF4040] animate-pulse"></span>
                                {{ subscription.has_active_subscription ? 'Subscription active' : 'Subscription required' }}
                            </div>

                            <div class="flex flex-col gap-6 md:flex-row md:items-end md:justify-between">
                                <div class="max-w-2xl">
                                    <h1 class="text-3xl font-bold tracking-tight md:text-4xl">
                                        Finance intelligence, now tied directly to your plan access.
                                    </h1>
                                    <p class="mt-4 text-sm leading-7 text-white/72 md:text-base">
                                        Use your billing center to unlock calculator access, manage payment methods, and keep your team’s forecasting workspace under control.
                                    </p>
                                </div>

                                <div class="rounded-[1.5rem] border border-white/12 bg-white/10 p-5 backdrop-blur-sm md:min-w-[260px]">
                                    <p class="text-[10px] font-semibold uppercase tracking-[0.28em] text-white/55">
                                        Current plan
                                    </p>
                                    <p class="mt-2 text-2xl font-semibold text-white">
                                        {{ subscription.plan_name }}
                                    </p>
                                    <p class="mt-2 text-sm text-white/65">
                                        Status: {{ subscription.status }}
                                    </p>
                                    <p class="mt-1 text-sm text-white/65">
                                        Interval: {{ subscription.interval || 'not set' }}
                                    </p>
                                </div>
                            </div>

                            <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                                <Link
                                    :href="route('billing.index')"
                                    class="inline-flex items-center justify-center rounded-2xl border border-[#FF4040] bg-[#FF4040] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#e23535]"
                                >
                                    {{ subscription.has_active_subscription ? 'Open Billing Center' : 'Choose a Plan' }}
                                </Link>
                                <Link
                                    :href="route('profile.edit')"
                                    class="inline-flex items-center justify-center rounded-2xl border border-white/15 bg-white/10 px-5 py-3 text-sm font-semibold text-white transition hover:bg-white/15"
                                >
                                    Update Profile
                                </Link>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-[2rem] border border-[#131747]/10 bg-white p-6 shadow-sm shadow-[#131747]/5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-[#FF4040]">
                                    Billing readiness
                                </p>
                                <h3 class="mt-2 text-xl font-semibold text-[#131747]">Workspace status</h3>
                            </div>
                            <span class="rounded-full bg-[#131747]/5 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-[#131747]/70">
                                Live
                            </span>
                        </div>

                        <div class="mt-6 space-y-4">
                            <div class="rounded-2xl border border-[#131747]/10 bg-[#131747]/5 p-4">
                                <p class="text-sm font-semibold text-[#131747]">Features enabled</p>
                                <p class="mt-2 text-3xl font-bold text-[#131747]">
                                    {{ (subscription.feature_access || []).length }}
                                </p>
                                <p class="mt-2 text-sm text-[#131747]/65">
                                    Calculators and tools are unlocked automatically from your current plan.
                                </p>
                            </div>

                            <div class="rounded-2xl border border-[#FF4040]/20 bg-[#FF4040]/8 p-4">
                                <p class="text-sm font-semibold text-[#131747]">Need more access?</p>
                                <p class="mt-2 text-sm leading-6 text-[#131747]/70">
                                    Upgrade in the billing center to unlock additional calculators, audit history, and ERP data workflows.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid gap-8 lg:grid-cols-[1.3fr,0.7fr]">
                    <div class="space-y-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-[#FF4040]">
                                    Product access
                                </p>
                                <h3 class="mt-2 text-2xl font-semibold text-[#131747]">
                                    Calculator suite
                                </h3>
                            </div>
                        </div>

                        <div class="grid gap-6 md:grid-cols-2">
                            <div
                                v-for="tool in tools"
                                :key="tool.slug"
                                class="flex flex-col justify-between rounded-[1.75rem] border border-[#131747]/10 bg-white p-6 shadow-sm shadow-[#131747]/5 transition duration-200 hover:-translate-y-1 hover:shadow-lg hover:shadow-[#131747]/10"
                            >
                                <div>
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl border border-[#131747]/10 bg-[#131747]/5 text-sm font-bold tracking-[0.18em] text-[#131747]">
                                            {{ tool.short }}
                                        </div>
                                        <span
                                            class="rounded-full px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.22em]"
                                            :class="
                                                hasFeature(tool.slug)
                                                    ? 'bg-[#131747]/5 text-[#131747]/65'
                                                    : 'bg-[#FF4040]/10 text-[#FF4040]'
                                            "
                                        >
                                            {{ hasFeature(tool.slug) ? tool.tag : 'Locked' }}
                                        </span>
                                    </div>

                                    <h4 class="mt-5 text-lg font-semibold text-[#131747]">
                                        {{ tool.title }}
                                    </h4>
                                    <p class="mt-3 text-sm leading-6 text-[#131747]/68">
                                        {{ tool.description }}
                                    </p>
                                </div>

                                <div class="mt-6">
                                    <Link
                                        :href="hasFeature(tool.slug) ? route(tool.route) : route('billing.index')"
                                        class="inline-flex w-full items-center justify-center rounded-2xl px-4 py-3 text-sm font-semibold transition"
                                        :class="
                                            hasFeature(tool.slug)
                                                ? 'border border-[#131747] bg-[#131747] text-white hover:border-[#FF4040] hover:bg-[#FF4040]'
                                                : 'border border-[#FF4040]/25 bg-[#FF4040]/8 text-[#FF4040] hover:bg-[#FF4040]/12'
                                        "
                                    >
                                        {{ hasFeature(tool.slug) ? 'Launch Calculator' : 'Upgrade to Unlock' }}
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-[2rem] border border-[#131747]/10 bg-white shadow-sm shadow-[#131747]/5">
                        <div class="flex items-center justify-between border-b border-[#131747]/10 bg-[#131747] px-6 py-5">
                            <h3 class="text-sm font-semibold uppercase tracking-[0.28em] text-white">
                                Insights stream
                            </h3>
                            <span class="flex h-3 w-3">
                                <span class="absolute inline-flex h-3 w-3 animate-ping rounded-full bg-[#FF4040] opacity-75"></span>
                                <span class="relative inline-flex h-3 w-3 rounded-full bg-[#FF4040]"></span>
                            </span>
                        </div>

                        <div class="space-y-4 p-5">
                            <div class="rounded-2xl border border-[#FF4040]/15 bg-[#FF4040]/8 p-4">
                                <div class="flex items-center justify-between gap-3">
                                    <p class="text-sm font-semibold text-[#131747]">Subscription Strategy</p>
                                    <span class="text-[10px] font-semibold uppercase tracking-[0.2em] text-[#FF4040]">
                                        New
                                    </span>
                                </div>
                                <p class="mt-3 text-sm leading-6 text-[#131747]/72">
                                    Your billing center now controls calculator access. Upgrade a plan to expand the workspace instantly.
                                </p>
                            </div>

                            <div class="rounded-2xl border border-[#131747]/10 bg-[#131747]/5 p-4">
                                <p class="text-sm font-semibold text-[#131747]">Profile Health</p>
                                <p class="mt-3 text-sm leading-6 text-[#131747]/72">
                                    Keep company and address details current so Stripe invoices and tax settings are ready when you go live.
                                </p>
                            </div>

                            <div class="rounded-2xl border border-[#131747]/10 bg-white p-4 shadow-sm shadow-[#131747]/5">
                                <p class="text-sm font-semibold text-[#131747]">Admin Visibility</p>
                                <p class="mt-3 text-sm leading-6 text-[#131747]/72">
                                    Admins can review users, plans, and local subscription status from the new operations panel.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
