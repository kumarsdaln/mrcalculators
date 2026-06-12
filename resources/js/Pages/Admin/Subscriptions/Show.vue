<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    subscription: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <Head title="Subscription Overview" />

    <AdminLayout>

        <template #header>
            <div>
                <p
                    class="text-xs font-semibold uppercase tracking-[0.3em] text-[#FF4040]"
                >
                    Revenue Management
                </p>

                <h1
                    class="mt-2 text-4xl font-black text-[#131747]"
                >
                    Subscription Overview
                </h1>

                <p
                    class="mt-2 text-[#131747]/60"
                >
                    Review customer subscription details, billing information,
                    and Stripe records.
                </p>
            </div>
        </template>

        <div class="space-y-8">

            <!-- Hero -->

            <div
                class="
                    relative
                    overflow-hidden
                    rounded-[2rem]
                    bg-[#131747]
                    p-8
                    text-white
                    shadow-xl
                "
            >
                <div
                    class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(255,64,64,0.25),_transparent_50%)]"
                />

                <div
                    class="relative flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between"
                >
                    <div>

                        <div
                            class="
                                inline-flex
                                rounded-full
                                bg-white/10
                                px-4
                                py-2
                                text-[10px]
                                font-bold
                                uppercase
                                tracking-widest
                            "
                        >
                            Active Subscription Record
                        </div>

                        <h2
                            class="mt-4 text-3xl font-black"
                        >
                            {{ subscription.user.name }}
                        </h2>

                        <p
                            class="mt-2 text-white/70"
                        >
                            {{ subscription.user.email }}
                        </p>

                    </div>

                    <span
                        class="
                            inline-flex
                            rounded-full
                            px-4
                            py-2
                            text-xs
                            font-bold
                            uppercase
                            tracking-widest
                        "
                        :class="{
                            'bg-green-500 text-white':
                                subscription.status === 'active',

                            'bg-yellow-500 text-white':
                                subscription.status === 'trialing',

                            'bg-red-500 text-white':
                                subscription.status === 'past_due',

                            'bg-slate-500 text-white':
                                !['active','trialing','past_due']
                                    .includes(subscription.status)
                        }"
                    >
                        {{ subscription.status }}
                    </span>

                </div>
            </div>

            <!-- Overview Cards -->

            <div
                class="grid gap-5 md:grid-cols-2 xl:grid-cols-4"
            >

                <div
                    class="
                        rounded-[1.5rem]
                        border
                        border-[#131747]/10
                        bg-white
                        p-6
                        shadow-sm
                    "
                >
                    <p
                        class="
                            text-[10px]
                            font-bold
                            uppercase
                            tracking-widest
                            text-[#131747]/40
                        "
                    >
                        Subscription Plan
                    </p>

                    <h3
                        class="
                            mt-3
                            text-xl
                            font-black
                            text-[#131747]
                        "
                    >
                        {{ subscription.plan || 'Unknown Plan' }}
                    </h3>
                </div>

                <div
                    class="
                        rounded-[1.5rem]
                        border
                        border-[#131747]/10
                        bg-white
                        p-6
                        shadow-sm
                    "
                >
                    <p
                        class="
                            text-[10px]
                            font-bold
                            uppercase
                            tracking-widest
                            text-[#131747]/40
                        "
                    >
                        Billing Cycle
                    </p>

                    <h3
                        class="
                            mt-3
                            text-xl
                            font-black
                            capitalize
                            text-[#131747]
                        "
                    >
                        {{ subscription.interval || 'N/A' }}
                    </h3>
                </div>

                <div
                    class="
                        rounded-[1.5rem]
                        border
                        border-[#131747]/10
                        bg-white
                        p-6
                        shadow-sm
                    "
                >
                    <p
                        class="
                            text-[10px]
                            font-bold
                            uppercase
                            tracking-widest
                            text-[#131747]/40
                        "
                    >
                        Subscription ID
                    </p>

                    <h3
                        class="
                            mt-3
                            text-xl
                            font-black
                            text-[#131747]
                        "
                    >
                        #{{ subscription.id }}
                    </h3>
                </div>

                <div
                    class="
                        rounded-[1.5rem]
                        border
                        border-[#131747]/10
                        bg-white
                        p-6
                        shadow-sm
                    "
                >
                    <p
                        class="
                            text-[10px]
                            font-bold
                            uppercase
                            tracking-widest
                            text-[#131747]/40
                        "
                    >
                        Created On
                    </p>

                    <h3
                        class="
                            mt-3
                            text-xl
                            font-black
                            text-[#131747]
                        "
                    >
                        {{
                            subscription.created_at
                                ? new Date(subscription.created_at)
                                      .toLocaleDateString()
                                : 'N/A'
                        }}
                    </h3>
                </div>

            </div>

            <!-- Customer Information -->

            <div
                class="
                    rounded-[2rem]
                    border
                    border-[#131747]/10
                    bg-white
                    p-8
                    shadow-sm
                "
            >
                <h3
                    class="
                        text-xl
                        font-black
                        text-[#131747]
                    "
                >
                    Customer Information
                </h3>

                <div
                    class="mt-6 grid gap-5 md:grid-cols-2"
                >

                    <div
                        class="
                            rounded-xl
                            bg-[#131747]/5
                            p-5
                        "
                    >
                        <p
                            class="
                                text-[10px]
                                font-bold
                                uppercase
                                tracking-widest
                                text-[#131747]/40
                            "
                        >
                            Customer Name
                        </p>

                        <p
                            class="
                                mt-2
                                font-bold
                                text-[#131747]
                            "
                        >
                            {{ subscription.user.name }}
                        </p>
                    </div>

                    <div
                        class="
                            rounded-xl
                            bg-[#131747]/5
                            p-5
                        "
                    >
                        <p
                            class="
                                text-[10px]
                                font-bold
                                uppercase
                                tracking-widest
                                text-[#131747]/40
                            "
                        >
                            Email Address
                        </p>

                        <p
                            class="
                                mt-2
                                font-medium
                                text-[#131747]
                            "
                        >
                            {{ subscription.user.email }}
                        </p>
                    </div>

                </div>
            </div>

            <!-- Stripe Information -->

            <div
                class="
                    rounded-[2rem]
                    border
                    border-[#131747]/10
                    bg-white
                    p-8
                    shadow-sm
                "
            >
                <h3
                    class="
                        text-xl
                        font-black
                        text-[#131747]
                    "
                >
                    Stripe Information
                </h3>

                <div
                    class="
                        mt-6
                        rounded-xl
                        bg-[#131747]/5
                        p-5
                    "
                >
                    <p
                        class="
                            text-[10px]
                            font-bold
                            uppercase
                            tracking-widest
                            text-[#131747]/40
                        "
                    >
                        Price IDs
                    </p>

                    <div
                        class="
                            mt-4
                            flex
                            flex-wrap
                            gap-2
                        "
                    >
                        <template
                            v-if="subscription.price_ids?.length"
                        >
                            <span
                                v-for="priceId in subscription.price_ids"
                                :key="priceId"
                                class="
                                    rounded-lg
                                    bg-[#131747]
                                    px-3
                                    py-2
                                    text-xs
                                    font-mono
                                    text-white
                                "
                            >
                                {{ priceId }}
                            </span>
                        </template>

                        <p
                            v-else
                            class="
                                text-sm
                                text-[#131747]/50
                            "
                        >
                            No Stripe price IDs available.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Notice -->

            <div
                class="
                    rounded-[2rem]
                    border
                    border-amber-200
                    bg-amber-50
                    p-6
                "
            >
                <h3
                    class="
                        font-bold
                        text-amber-900
                    "
                >
                    Billing Management Notice
                </h3>

                <p
                    class="
                        mt-3
                        text-sm
                        leading-relaxed
                        text-amber-800
                    "
                >
                    Subscription upgrades, downgrades, cancellations,
                    invoice adjustments, and payment method changes should
                    be managed through Stripe. This ensures invoices,
                    billing records, customer access, and webhooks remain
                    synchronized.
                </p>
            </div>

            <!-- Actions -->

            <div
                class="
                    flex
                    flex-wrap
                    gap-3
                "
            >

                <Link
                    :href="route('admin.subscriptions.index')"
                    class="
                        rounded-xl
                        border
                        border-[#131747]/10
                        px-6
                        py-3
                        text-sm
                        font-bold
                        text-[#131747]
                    "
                >
                    Back to Subscriptions
                </Link>
            </div>

        </div>

    </AdminLayout>
</template>