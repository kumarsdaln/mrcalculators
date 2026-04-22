<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { Head, Link } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps({
    plans: {
        type: Array,
        required: true,
    },
    subscription: {
        type: Object,
        required: true,
    },
    currentPlan: {
        type: Object,
        default: null,
    },
    features: {
        type: Array,
        required: true,
    },
    stripeConfigured: {
        type: Boolean,
        required: true,
    },
    invoices: {
        type: Array,
        required: true,
    },
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
            <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-[#FF4040]">
                        Revenue operations
                    </p>
                    <h2 class="mt-2 text-2xl font-bold leading-tight text-[#131747]">
                        Subscription & Billing
                    </h2>
                </div>
                <Link
                    :href="route('profile.edit')"
                    class="inline-flex items-center justify-center rounded-2xl border border-[#131747]/10 bg-white px-5 py-3 text-sm font-semibold text-[#131747] shadow-sm shadow-[#131747]/5 transition hover:border-[#FF4040]/30 hover:text-[#FF4040]"
                >
                    Back to Profile
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-8 px-4 sm:px-6 lg:px-8">
                <div class="rounded-[2rem] border border-[#131747] bg-[#131747] p-8 text-white shadow-[0_28px_100px_-40px_rgba(19,23,71,0.85)]">
                    <div class="grid gap-6 lg:grid-cols-[1.1fr,0.9fr]">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-[#FF4040]">
                                Billing status
                            </p>
                            <h3 class="mt-3 text-3xl font-bold">
                                {{ subscription.plan_name }}
                            </h3>
                            <p class="mt-3 max-w-2xl text-sm leading-7 text-white/72">
                                Use Stripe Checkout for new subscriptions, the billing portal for updates, and this page to keep visibility over plan access and invoices.
                            </p>
                        </div>

                        <div class="rounded-[1.5rem] border border-white/12 bg-white/10 p-5 backdrop-blur-sm">
                            <div class="grid gap-4 sm:grid-cols-2">
                                <div>
                                    <p class="text-[10px] font-semibold uppercase tracking-[0.28em] text-white/55">Status</p>
                                    <p class="mt-2 text-lg font-semibold text-white">{{ subscription.status }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-semibold uppercase tracking-[0.28em] text-white/55">Interval</p>
                                    <p class="mt-2 text-lg font-semibold text-white">{{ subscription.interval || 'not set' }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-semibold uppercase tracking-[0.28em] text-white/55">Payment Method</p>
                                    <p class="mt-2 text-sm font-medium text-white">{{ subscription.payment_method || 'Not connected yet' }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-semibold uppercase tracking-[0.28em] text-white/55">Last Four</p>
                                    <p class="mt-2 text-sm font-medium text-white">{{ subscription.payment_method_last_four || '----' }}</p>
                                </div>
                            </div>

                            <div class="mt-5 flex flex-col gap-3 sm:flex-row">
                                <Link
                                    v-if="subscription.has_active_subscription"
                                    :href="route('billing.portal')"
                                    method="post"
                                    as="button"
                                    class="inline-flex items-center justify-center rounded-2xl border border-[#FF4040] bg-[#FF4040] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#e23535]"
                                >
                                    Open Billing Portal
                                </Link>
                                <Link
                                    v-if="subscription.has_active_subscription && !subscription.on_grace_period"
                                    :href="route('billing.cancel')"
                                    method="post"
                                    as="button"
                                    class="inline-flex items-center justify-center rounded-2xl border border-white/15 bg-white/10 px-5 py-3 text-sm font-semibold text-white transition hover:bg-white/15"
                                >
                                    Cancel at Period End
                                </Link>
                                <Link
                                    v-if="subscription.on_grace_period"
                                    :href="route('billing.resume')"
                                    method="post"
                                    as="button"
                                    class="inline-flex items-center justify-center rounded-2xl border border-white/15 bg-white/10 px-5 py-3 text-sm font-semibold text-white transition hover:bg-white/15"
                                >
                                    Resume Subscription
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    v-if="!stripeConfigured"
                    class="rounded-[1.75rem] border border-[#FF4040]/20 bg-[#FF4040]/8 p-5 text-sm leading-6 text-[#131747]/75"
                >
                    Stripe billing is not configured yet. Add `STRIPE_KEY`, `STRIPE_SECRET`, and your plan price IDs to fully activate checkout, portal access, and invoices.
                </div>

                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.28em] text-[#FF4040]">
                            Plans
                        </p>
                        <h3 class="mt-2 text-2xl font-semibold text-[#131747]">
                            Choose the access level your team needs
                        </h3>
                    </div>

                    <div class="inline-flex rounded-2xl border border-[#131747]/10 bg-white p-1 shadow-sm shadow-[#131747]/5">
                        <button
                            type="button"
                            class="rounded-xl px-4 py-2 text-sm font-semibold transition"
                            :class="
                                billingInterval === 'monthly'
                                    ? 'bg-[#131747] text-white'
                                    : 'text-[#131747]/65 hover:text-[#131747]'
                            "
                            @click="billingInterval = 'monthly'"
                        >
                            Monthly
                        </button>
                        <button
                            type="button"
                            class="rounded-xl px-4 py-2 text-sm font-semibold transition"
                            :class="
                                billingInterval === 'yearly'
                                    ? 'bg-[#131747] text-white'
                                    : 'text-[#131747]/65 hover:text-[#131747]'
                            "
                            @click="billingInterval = 'yearly'"
                        >
                            Yearly
                        </button>
                    </div>
                </div>

                <div class="grid gap-6 lg:grid-cols-3">
                    <div
                        v-for="plan in plans"
                        :key="plan.id"
                        class="flex flex-col justify-between rounded-[1.75rem] border bg-white p-6 shadow-sm transition duration-200"
                        :class="
                            plan.is_featured
                                ? 'border-[#FF4040]/30 shadow-lg shadow-[#131747]/10'
                                : 'border-[#131747]/10 shadow-[#131747]/5'
                        "
                    >
                        <div>
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-sm font-semibold text-[#131747]">{{ plan.name }}</p>
                                    <p class="mt-3 text-sm leading-6 text-[#131747]/68">
                                        {{ plan.description }}
                                    </p>
                                </div>
                                <span
                                    v-if="plan.is_featured"
                                    class="rounded-full bg-[#FF4040]/10 px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.22em] text-[#FF4040]"
                                >
                                    Most Popular
                                </span>
                            </div>

                            <div class="mt-6">
                                <p class="text-4xl font-bold tracking-tight text-[#131747]">
                                    {{ displayedPrice(plan) || 'Custom' }}
                                </p>
                                <p class="mt-2 text-sm text-[#131747]/55">
                                    per {{ billingInterval === 'yearly' ? 'year' : 'month' }}
                                </p>
                                <p v-if="plan.trial_days" class="mt-3 text-sm font-medium text-[#FF4040]">
                                    {{ plan.trial_days }}-day trial included
                                </p>
                            </div>

                            <div class="mt-6 space-y-3">
                                <div
                                    v-for="featureSlug in plan.feature_access"
                                    :key="featureSlug"
                                    class="flex items-start gap-3 rounded-2xl border border-[#131747]/8 bg-[#131747]/5 px-4 py-3"
                                >
                                    <span class="mt-1 h-2.5 w-2.5 rounded-full bg-[#FF4040]"></span>
                                    <div>
                                        <p class="text-sm font-semibold text-[#131747]">
                                            {{ featureLookup[featureSlug]?.name || featureSlug }}
                                        </p>
                                        <p class="mt-1 text-xs leading-5 text-[#131747]/60">
                                            {{ featureLookup[featureSlug]?.description }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 space-y-3">
                            <Link
                                v-if="plan.is_current"
                                :href="route('billing.portal')"
                                method="post"
                                as="button"
                                class="inline-flex w-full items-center justify-center rounded-2xl border border-[#131747] bg-[#131747] px-4 py-3 text-sm font-semibold text-white transition hover:border-[#FF4040] hover:bg-[#FF4040]"
                            >
                                Current Plan
                            </Link>

                            <Link
                                v-else-if="subscription.has_active_subscription"
                                :href="route('billing.portal')"
                                method="post"
                                as="button"
                                class="inline-flex w-full items-center justify-center rounded-2xl border border-[#131747]/15 bg-white px-4 py-3 text-sm font-semibold text-[#131747] transition hover:border-[#FF4040]/30 hover:text-[#FF4040]"
                            >
                                Change Plan in Portal
                            </Link>

                            <Link
                                v-else-if="stripeConfigured && supportsSelectedInterval(plan) && plan.checkout_ready[billingInterval]"
                                :href="route('billing.checkout', { plan: plan.id, interval: billingInterval })"
                                method="post"
                                as="button"
                                class="inline-flex w-full items-center justify-center rounded-2xl border border-[#131747] bg-[#131747] px-4 py-3 text-sm font-semibold text-white transition hover:border-[#FF4040] hover:bg-[#FF4040]"
                            >
                                Start Subscription
                            </Link>

                            <button
                                v-else
                                type="button"
                                disabled
                                class="inline-flex w-full cursor-not-allowed items-center justify-center rounded-2xl border border-[#131747]/10 bg-[#131747]/5 px-4 py-3 text-sm font-semibold text-[#131747]/45"
                            >
                                Configure Stripe Price ID First
                            </button>
                        </div>
                    </div>
                </div>

                <div class="rounded-[1.75rem] border border-[#131747]/10 bg-white p-6 shadow-sm shadow-[#131747]/5">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-[#FF4040]">
                                Invoice history
                            </p>
                            <h3 class="mt-2 text-2xl font-semibold text-[#131747]">
                                Recent billing documents
                            </h3>
                        </div>
                    </div>

                    <div v-if="invoices.length" class="mt-6 overflow-x-auto">
                        <table class="min-w-full divide-y divide-[#131747]/10 text-left text-sm">
                            <thead>
                                <tr class="text-[#131747]/50">
                                    <th class="pb-3 font-semibold">Invoice</th>
                                    <th class="pb-3 font-semibold">Date</th>
                                    <th class="pb-3 font-semibold">Total</th>
                                    <th class="pb-3 font-semibold">Status</th>
                                    <th class="pb-3 font-semibold">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#131747]/8">
                                <tr v-for="invoice in invoices" :key="invoice.id">
                                    <td class="py-4 font-medium text-[#131747]">{{ invoice.id }}</td>
                                    <td class="py-4 text-[#131747]/68">
                                        {{ new Date(invoice.date).toLocaleDateString() }}
                                    </td>
                                    <td class="py-4 text-[#131747]/68">{{ invoice.total }}</td>
                                    <td class="py-4">
                                        <span class="rounded-full bg-[#131747]/5 px-3 py-1 text-xs font-semibold uppercase tracking-[0.18em] text-[#131747]/70">
                                            {{ invoice.status }}
                                        </span>
                                    </td>
                                    <td class="py-4">
                                        <div class="flex flex-wrap gap-3">
                                            <a
                                                v-if="invoice.hosted_invoice_url"
                                                :href="invoice.hosted_invoice_url"
                                                target="_blank"
                                                rel="noreferrer"
                                                class="font-semibold text-[#131747] transition hover:text-[#FF4040]"
                                            >
                                                View
                                            </a>
                                            <a
                                                v-if="invoice.invoice_pdf"
                                                :href="invoice.invoice_pdf"
                                                target="_blank"
                                                rel="noreferrer"
                                                class="font-semibold text-[#131747]/65 transition hover:text-[#FF4040]"
                                            >
                                                PDF
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div v-else class="mt-6 rounded-2xl border border-[#131747]/10 bg-[#131747]/5 px-4 py-4 text-sm text-[#131747]/65">
                        Invoices will appear here once Stripe billing is configured and a subscription has generated billing activity.
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
