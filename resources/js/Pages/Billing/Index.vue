<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import { 
    CreditCard, 
    ArrowLeft, 
    Zap, 
    Calendar, 
    ShieldCheck, 
    Download, 
    ExternalLink, 
    CheckCircle2, 
    Info, 
    ArrowUpRight,
    Sparkles,
    FileText,
    Activity
} from 'lucide-vue-next';

const props = defineProps({
    plans: { type: Array, required: true },
    subscription: { type: Object, required: true },
    currentPlan: { type: Object, default: null },
    features: { type: Array, required: true },
    stripeConfigured: { type: Boolean, required: true },
    invoices: { type: Array, required: true },
});

const billingInterval = ref(props.subscription.interval || 'monthly');

const featureLookup = computed(() =>
    Object.fromEntries(props.features.map((feature) => [feature.slug, feature])),
);

const displayedPrice = (plan) =>
    billingInterval.value === 'yearly'
        ? plan.yearly_price_display ?? plan.monthly_price_display
        : plan.monthly_price_display ?? plan.yearly_price_display;

const supportsSelectedInterval = (plan) =>
    plan.intervals.includes(billingInterval.value);
</script>

<template>
    <Head title="Subscription & Billing" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <div class="flex items-center gap-2">
                         <div class="h-2 w-8 bg-[#FF4040] rounded-full"></div>
                         <p class="text-[10px] font-black uppercase tracking-[0.3em] text-[#FF4040]">Revenue Operations</p>
                    </div>
                    <h2 class="mt-2 text-3xl font-black tracking-tight text-[#131747]">
                        Billing <span class="text-[#131747]/40">&</span> Access
                    </h2>
                </div>
                <Link
                    :href="route('profile.edit')"
                    class="group inline-flex items-center gap-2 rounded-2xl border border-[#131747]/10 bg-white px-5 py-3 text-sm font-bold text-[#131747] shadow-sm transition-all hover:bg-gray-50 active:scale-95"
                >
                    <ArrowLeft :size="18" class="transition-transform group-hover:-translate-x-1" />
                    Back to Profile
                </Link>
            </div>
        </template>

        <div class="py-10">
            <div class="mx-auto max-w-7xl space-y-10 px-4 sm:px-6 lg:px-8">
                
                <!-- Main Status Hero Card -->
                <div class="relative overflow-hidden rounded-[2.5rem] bg-[#131747] p-1 shadow-2xl">
                    <!-- Background Decoration -->
                    <div class="absolute -right-20 -top-20 h-64 w-64 rounded-full bg-[#FF4040]/20 blur-[100px]"></div>
                    <div class="absolute -bottom-20 -left-20 h-64 w-64 rounded-full bg-blue-500/10 blur-[100px]"></div>

                    <div class="relative grid gap-8 rounded-[2.3rem] bg-[#131747] p-8 lg:grid-cols-[1fr,400px]">
                        <div class="flex flex-col justify-between">
                            <div>
                                <div class="inline-flex items-center gap-2 rounded-full bg-[#FF4040]/10 px-4 py-1 text-[10px] font-bold uppercase tracking-widest text-[#FF4040]">
                                    <Sparkles :size="12" class="fill-[#FF4040]" />
                                    Active Account
                                </div>
                                <h3 class="mt-6 text-4xl font-black text-white">
                                    {{ subscription.plan_name }}
                                </h3>
                                <p class="mt-4 max-w-lg text-sm leading-relaxed text-white/60">
                                    Your current subscription level allows you to access premium financial modeling tools and custom report exports.
                                </p>
                            </div>

                            <div class="mt-10 flex flex-wrap gap-4">
                                <Link v-if="subscription.has_active_subscription" :href="route('billing.portal')" method="post" as="button"
                                    class="inline-flex items-center gap-2 rounded-2xl bg-[#FF4040] px-6 py-3.5 text-sm font-bold text-white shadow-lg shadow-[#FF4040]/30 transition hover:-translate-y-0.5 hover:bg-[#e23535] active:translate-y-0">
                                    Manage Payments <ArrowUpRight :size="18" />
                                </Link>
                                <Link v-if="subscription.has_active_subscription && !subscription.on_grace_period" :href="route('billing.cancel')" method="post" as="button"
                                    class="inline-flex items-center rounded-2xl bg-white/5 border border-white/10 px-6 py-3.5 text-sm font-bold text-white transition hover:bg-white/10">
                                    Cancel Subscription
                                </Link>
                                <Link v-if="subscription.on_grace_period" :href="route('billing.resume')" method="post" as="button"
                                    class="inline-flex items-center rounded-2xl bg-green-500 px-6 py-3.5 text-sm font-bold text-white transition hover:bg-green-600">
                                    Resume Access
                                </Link>
                            </div>
                        </div>

                        <!-- Info Grid Wrapper -->
                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="rounded-3xl bg-white/5 p-5 border border-white/10">
                                    <Activity :size="20" class="text-[#FF4040] mb-3" />
                                    <p class="text-[10px] font-bold uppercase tracking-widest text-white/40">Status</p>
                                    <p class="mt-1 text-sm font-bold text-white capitalize">{{ subscription.status }}</p>
                                </div>
                                <div class="rounded-3xl bg-white/5 p-5 border border-white/10">
                                    <Calendar :size="20" class="text-[#FF4040] mb-3" />
                                    <p class="text-[10px] font-bold uppercase tracking-widest text-white/40">Interval</p>
                                    <p class="mt-1 text-sm font-bold text-white capitalize">{{ subscription.interval || 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="rounded-3xl bg-white/5 p-6 border border-white/10">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-[10px] font-bold uppercase tracking-widest text-white/40">Payment Method</p>
                                        <div class="mt-2 flex items-center gap-3">
                                            <div class="flex h-8 w-12 items-center justify-center rounded-lg bg-white/10">
                                                <CreditCard :size="20" class="text-white" />
                                            </div>
                                            <div>
                                                <p class="text-sm font-bold text-white leading-none capitalize">
                                                    {{ subscription.payment_method || 'Not Linked' }}
                                                </p>
                                                <p class="mt-1 text-xs text-white/40 font-mono">
                                                    **** {{ subscription.payment_method_last_four || '----' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <ShieldCheck :size="32" class="text-white/10" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Missing Config Alert -->
                <div v-if="!stripeConfigured" class="flex items-center gap-4 rounded-3xl border border-[#FF4040]/20 bg-[#FF4040]/5 p-6 animate-pulse">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-[#FF4040] text-white">
                        <Info :size="24" />
                    </div>
                    <div>
                        <h4 class="font-bold text-[#131747]">Action Required: Stripe Not Configured</h4>
                        <p class="text-sm text-[#131747]/60">Check your <code class="bg-white px-1 font-bold">.env</code> for STRIPE_KEY and Price IDs to enable billing.</p>
                    </div>
                </div>

                <!-- Plan Selection -->
                <div class="space-y-6">
                    <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between px-2">
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-[0.3em] text-[#FF4040]">Upgrade</p>
                            <h3 class="mt-2 text-2xl font-black text-[#131747]">Available Plans</h3>
                        </div>

                        <div class="inline-flex rounded-2xl bg-gray-100 p-1.5">
                            <button @click="billingInterval = 'monthly'"
                                class="rounded-xl px-6 py-2.5 text-sm font-bold transition-all"
                                :class="billingInterval === 'monthly' ? 'bg-[#131747] text-white shadow-lg' : 'text-[#131747]/50 hover:text-[#131747]'">
                                Monthly
                            </button>
                            <button @click="billingInterval = 'yearly'"
                                class="rounded-xl px-6 py-2.5 text-sm font-bold transition-all"
                                :class="billingInterval === 'yearly' ? 'bg-[#131747] text-white shadow-lg' : 'text-[#131747]/50 hover:text-[#131747]'">
                                Yearly
                            </button>
                        </div>
                    </div>

                    <div class="grid gap-8 lg:grid-cols-3">
                        <div v-for="plan in plans" :key="plan.id" 
                            class="group relative flex flex-col justify-between rounded-[2.5rem] border bg-white p-8 transition-all duration-300 hover:shadow-2xl hover:shadow-[#131747]/10"
                            :class="plan.is_current ? 'border-[#131747] ring-1 ring-[#131747]' : 'border-gray-100'">
                            
                            <div v-if="plan.is_featured" class="absolute -top-4 left-1/2 -translate-x-1/2 rounded-full bg-[#FF4040] px-4 py-1 text-[10px] font-black uppercase tracking-widest text-white">
                                Recommended
                            </div>

                            <div>
                                <div class="flex items-start justify-between">
                                    <h4 class="text-xl font-black text-[#131747]">{{ plan.name }}</h4>
                                    <div v-if="plan.is_current" class="rounded-full bg-green-500 p-1 text-white">
                                        <CheckCircle2 :size="16" />
                                    </div>
                                </div>
                                <p class="mt-4 text-sm leading-relaxed text-[#131747]/60">{{ plan.description }}</p>

                                <div class="mt-8 border-b border-gray-100 pb-8">
                                    <p class="text-5xl font-black tracking-tight text-[#131747]">
                                        {{ displayedPrice(plan) || 'Custom' }}
                                    </p>
                                    <p class="mt-2 text-xs font-bold uppercase tracking-widest text-[#131747]/40">
                                        Per {{ billingInterval }}
                                    </p>
                                </div>

                                <div class="mt-8 space-y-4">
                                    <div v-for="featureSlug in plan.feature_access" :key="featureSlug" class="flex gap-3">
                                        <Zap :size="16" class="mt-0.5 shrink-0 text-[#FF4040]" />
                                        <div>
                                            <p class="text-sm font-bold text-[#131747]">{{ featureLookup[featureSlug]?.name || featureSlug }}</p>
                                            <p class="text-[11px] text-[#131747]/50">{{ featureLookup[featureSlug]?.description }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-10">
                                <Link v-if="plan.is_current" :href="route('billing.portal')" method="post" as="button"
                                    class="w-full rounded-2xl bg-[#131747] py-4 text-sm font-black text-white transition hover:bg-[#FF4040]">
                                    Current Plan
                                </Link>
                                <Link v-else-if="subscription.has_active_subscription" :href="route('billing.portal')" method="post" as="button"
                                    class="w-full rounded-2xl border border-[#131747]/10 bg-white py-4 text-sm font-black text-[#131747] transition hover:bg-gray-50">
                                    Switch Plan
                                </Link>
                                <Link v-else-if="stripeConfigured && supportsSelectedInterval(plan) && plan.checkout_ready[billingInterval]"
                                    :href="route('billing.checkout', { plan: plan.id, interval: billingInterval })" method="post" as="button"
                                    class="w-full rounded-2xl bg-gray-100 py-4 text-sm font-black text-[#131747] transition hover:bg-[#FF4040] hover:text-white">
                                    Select Plan
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Invoice Table -->
                <div class="overflow-hidden rounded-[2.5rem] border border-gray-100 bg-white shadow-sm">
                    <div class="border-b border-gray-50 bg-gray-50/50 p-8">
                        <div class="flex items-center gap-3">
                            <FileText class="text-[#FF4040]" :size="24" />
                            <h3 class="text-xl font-black text-[#131747]">Billing History</h3>
                        </div>
                    </div>

                    <div class="p-4 sm:p-8">
                        <div v-if="invoices.length" class="overflow-x-auto">
                            <table class="w-full border-collapse text-left text-sm">
                                <thead>
                                    <tr class="border-b border-gray-100 text-[10px] font-black uppercase tracking-widest text-[#131747]/40">
                                        <th class="pb-4 px-2">Invoice ID</th>
                                        <th class="pb-4 px-2">Date</th>
                                        <th class="pb-4 px-2">Amount</th>
                                        <th class="pb-4 px-2 text-center">Status</th>
                                        <th class="pb-4 px-2 text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    <tr v-for="invoice in invoices" :key="invoice.id" class="group transition hover:bg-gray-50/50">
                                        <td class="py-5 px-2 font-mono text-xs font-bold text-[#131747]">{{ invoice.id }}</td>
                                        <td class="py-5 px-2 text-[#131747]/60">{{ new Date(invoice.date).toLocaleDateString() }}</td>
                                        <td class="py-5 px-2 font-bold text-[#131747]">{{ invoice.total }}</td>
                                        <td class="py-5 px-2 text-center">
                                            <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-[10px] font-bold uppercase tracking-widest text-green-700">
                                                {{ invoice.status }}
                                            </span>
                                        </td>
                                        <td class="py-5 px-2 text-right">
                                            <div class="flex justify-end gap-2">
                                                <a v-if="invoice.hosted_invoice_url" :href="invoice.hosted_invoice_url" target="_blank"
                                                    class="inline-flex items-center gap-1 rounded-xl bg-gray-100 px-3 py-2 text-xs font-bold text-[#131747] transition hover:bg-[#131747] hover:text-white">
                                                    View <ExternalLink :size="12" />
                                                </a>
                                                <a v-if="invoice.invoice_pdf" :href="invoice.invoice_pdf" target="_blank"
                                                    class="inline-flex items-center gap-1 rounded-xl bg-[#FF4040]/10 px-3 py-2 text-xs font-bold text-[#FF4040] transition hover:bg-[#FF4040] hover:text-white">
                                                    PDF <Download :size="12" />
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div v-else class="flex flex-col items-center justify-center py-12 text-center">
                            <div class="rounded-full bg-gray-100 p-6 text-gray-400">
                                <FileText :size="40" />
                            </div>
                            <p class="mt-4 font-bold text-[#131747]">No billing history yet</p>
                            <p class="mt-1 text-sm text-gray-500">Your invoices will appear here after your first payment.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.animate-pulse {
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: .7; }
}
</style>