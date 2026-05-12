<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { 
    Target, 
    Calculator, 
    TrendingUp, 
    Zap, 
    BarChart, 
    ChevronRight,
    ShieldCheck,
    CreditCard,
    ArrowUpRight
} from 'lucide-vue-next';

const page = usePage();
const subscription = computed(() => page.props.auth.subscription ?? {});
const isAdmin = computed(() => page.props.auth.user?.is_admin ?? false);

const tools = [
    {
        slug: 'monthly_sales_goal',
        icon: Target,
        title: 'Monthly Quota Isolator',
        description: 'Convert annual revenue targets into actionable monthly sales quotas.',
        route: 'calculator.monthly-sales-goal',
        tag: 'Starter',
    },
    {
        slug: 'break_even_price',
        icon: Calculator,
        title: 'Break-Even Matrix',
        description: 'Identify the exact price floor required to cover all operating costs.',
        route: 'calculator.break-even-and-selling-price',
        tag: 'Starter',
    },
    {
        slug: 'future_sales_forecast',
        icon: TrendingUp,
        title: 'Predictive Forecaster',
        description: 'Analyze historical trends to project future revenue performance.',
        route: 'calculator.future-sales-forecast',
        tag: 'Growth',
    },
    {
        slug: 'what_if_engine',
        icon: Zap,
        title: 'Scenario Engine',
        description: 'Stress-test your margins against fluctuating costs and price shifts.',
        route: 'calculator.what-if-engine',
        tag: 'Growth',
    },
    {
        slug: 'ltv_cac_ratio',
        icon: BarChart,
        title: 'LTV : CAC Health',
        description: 'Measure customer lifetime value against acquisition costs.',
        route: 'calculator.ltv-cac-ratio',
        tag: 'Scale',
    },
];

const hasFeature = (slug) => isAdmin.value || (subscription.value.feature_access ?? []).includes(slug);
</script>

<template>
    <Head title="Financial Command Center" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-[#FF4040]">
                        Core Intelligence Unit
                    </p>
                    <h2 class="mt-2 text-3xl font-extrabold tracking-tight text-[#131747]">
                        Financial <span class="text-[#131747]/40">Command Center</span>
                    </h2>
                </div>
                <Link
                    :href="route('billing.index')"
                    class="inline-flex items-center gap-2 rounded-xl border border-[#131747]/10 bg-white px-5 py-2.5 text-sm font-bold text-[#131747] shadow-sm transition-all hover:border-[#131747] hover:bg-[#131747] hover:text-white"
                >
                    <CreditCard class="w-4 h-4" />
                    Billing & Access
                </Link>
            </div>
        </template>

        <div class="py-10">
            <div class="mx-auto max-w-7xl space-y-8 px-4 sm:px-6 lg:px-8">
                
                <!-- Hero: Access Status -->
                <div class="relative overflow-hidden rounded-[2.5rem] border border-[#131747] bg-[#131747] p-8 text-white shadow-2xl md:p-12">
                    <!-- Theme Decoration -->
                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(255,64,64,0.3),_transparent_40%)]"></div>
                    
                    <div class="relative z-10 grid gap-10 lg:grid-cols-2 lg:items-center">
                        <div>
                            <div class="mb-6 inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-4 py-1.5 text-[10px] font-black uppercase tracking-widest text-white">
                                <span class="h-2 w-2 rounded-full bg-[#FF4040] animate-pulse"></span>
                                {{ subscription.has_active_subscription ? 'Authorized Access' : 'Limited Access' }}
                            </div>
                            <h1 class="text-4xl font-extrabold leading-tight tracking-tighter md:text-5xl">
                                Strategic Finance <br/> 
                                <span class="opacity-40 text-3xl md:text-4xl">Precision Analysis Tools.</span>
                            </h1>
                            <p class="mt-6 max-w-lg text-lg text-white/60 leading-relaxed">
                                Professional grade calculators designed to isolate profit leakages and forecast growth with mathematical certainty.
                            </p>
                        </div>

                        <div class="rounded-3xl border border-white/10 bg-white/5 p-8 backdrop-blur-md">
                            <div class="flex items-center justify-between border-b border-white/10 pb-6 mb-6">
                                <div>
                                    <p class="text-[10px] font-bold uppercase tracking-widest text-white/40">Active Tier</p>
                                    <h3 class="text-2xl font-black">{{ subscription.plan_name }}</h3>
                                </div>
                                <ShieldCheck class="h-10 w-10 text-[#FF4040]" />
                            </div>
                            <div class="flex flex-col gap-4 sm:flex-row">
                                <Link :href="route('billing.index')" class="flex-1 rounded-xl bg-[#FF4040] px-6 py-3 text-center text-sm font-black uppercase tracking-widest text-white transition hover:bg-[#e23535]">
                                    Upgrade Plan
                                </Link>
                                <div class="flex items-center justify-center px-4 py-2 rounded-xl bg-white/10 text-xs font-bold uppercase">
                                    {{ (subscription.feature_access || []).length }} Modules Active
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tools Grid -->
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    <div
                        v-for="tool in tools"
                        :key="tool.slug"
                        class="group relative flex flex-col justify-between rounded-[2rem] border border-[#131747]/5 bg-white p-8 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-[#131747]/5"
                    >
                        <div>
                            <div class="flex items-center justify-between">
                                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-[#131747]/5 text-[#131747] transition-all group-hover:bg-[#131747] group-hover:text-white">
                                    <component :is="tool.icon" class="h-7 w-7" />
                                </div>
                                <span
                                    class="rounded-full px-3 py-1 text-[9px] font-black uppercase tracking-widest"
                                    :class="hasFeature(tool.slug) ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-500'"
                                >
                                    {{ hasFeature(tool.slug) ? tool.tag : 'Locked' }}
                                </span>
                            </div>

                            <h4 class="mt-8 text-xl font-black tracking-tight text-[#131747]">
                                {{ tool.title }}
                            </h4>
                            <p class="mt-3 text-sm leading-relaxed text-[#131747]/60">
                                {{ tool.description }}
                            </p>
                        </div>

                        <div class="mt-10">
                            <Link
                                :href="hasFeature(tool.slug) ? route(tool.route) : route('billing.index')"
                                class="inline-flex w-full items-center justify-between rounded-xl px-5 py-4 text-sm font-bold transition-all"
                                :class="hasFeature(tool.slug)
                                    ? 'bg-[#131747] text-white hover:bg-[#FF4040]'
                                    : 'bg-[#131747]/5 text-[#131747]/40'
                                "
                            >
                                <span>{{ hasFeature(tool.slug) ? 'Open' : 'Unlock Module' }}</span>
                                <ChevronRight v-if="hasFeature(tool.slug)" class="w-4 h-4" />
                                <ArrowUpRight v-else class="w-4 h-4" />
                            </Link>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
