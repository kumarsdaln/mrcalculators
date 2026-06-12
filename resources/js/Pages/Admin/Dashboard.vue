<script setup>
    import AdminLayout from '@/Layouts/AdminLayout.vue';
    import { Head, Link } from '@inertiajs/vue3';

    defineProps({
        stats: {
            type: Object,
            required: true,
        },
        stripeConfigured: {
            type: Boolean,
            required: true,
        },
    });
</script>

<template>

    <Head title="Admin Dashboard" />

    <AdminLayout>
        <template #header>
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">


                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-[#FF4040]">
                        Administration
                    </p>

                    <h1 class="mt-2 text-4xl font-black tracking-tight text-[#131747]">
                        Dashboard
                    </h1>

                    <p class="mt-2 text-sm text-[#131747]/60">
                        Monitor users, subscriptions, plans, and platform activity.
                    </p>
                </div>

                <div class="flex gap-3">
                    <Link :href="route('admin.plans.index')"
                        class="rounded-xl bg-[#131747] px-5 py-3 text-sm font-bold text-white hover:bg-[#FF4040]">
                    Create Plan
                    </Link>

                    <Link :href="route('admin.users.index')"
                        class="rounded-xl border border-[#131747]/10 bg-white px-5 py-3 text-sm font-bold text-[#131747]">
                    Manage Users
                    </Link>
                </div>

            </div>


        </template>

        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">


            <!-- Revenue -->
            <div class="rounded-[2rem] bg-[#131747] p-6 text-white shadow-xl">
                <p class="text-xs uppercase tracking-widest text-white/50">
                    Monthly Revenue
                </p>

                <h3 class="mt-4 text-4xl font-black">
                    {{ stats.mrr_estimate }}
                </h3>

                <p class="mt-2 text-sm text-white/60">
                    Estimated recurring revenue
                </p>
            </div>

            <!-- Subscribers -->
            <div class="rounded-[2rem] border border-[#131747]/10 bg-white p-6">
                <p class="text-xs uppercase tracking-widest text-[#131747]/50">
                    Active Subscribers
                </p>

                <h3 class="mt-4 text-4xl font-black text-[#131747]">
                    {{ stats.active_subscribers }}
                </h3>

                <p class="mt-2 text-sm text-green-600">
                    Active paying customers
                </p>
            </div>

            <!-- Users -->
            <div class="rounded-[2rem] border border-[#131747]/10 bg-white p-6">
                <p class="text-xs uppercase tracking-widest text-[#131747]/50">
                    Total Users
                </p>

                <h3 class="mt-4 text-4xl font-black text-[#131747]">
                    {{ stats.users }}
                </h3>

                <p class="mt-2 text-sm text-[#131747]/60">
                    Registered accounts
                </p>
            </div>

            <!-- Past Due -->
            <div class="rounded-[2rem] border border-red-200 bg-red-50 p-6">
                <p class="text-xs uppercase tracking-widest text-red-500">
                    Past Due
                </p>

                <h3 class="mt-4 text-4xl font-black text-red-600">
                    {{ stats.past_due_subscribers }}
                </h3>

                <p class="mt-2 text-sm text-red-500">
                    Require attention
                </p>
            </div>


        </div>

        <div class="grid gap-6 lg:grid-cols-3 mt-8">


            <!-- Quick Actions -->
            <div class="lg:col-span-2 rounded-[2rem] border border-[#131747]/10 bg-white p-8">
                <h3 class="text-xl font-black text-[#131747]">
                    Quick Actions
                </h3>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6">

                    <Link :href="route('admin.users.index')"
                        class="rounded-2xl bg-[#F8F9FC] p-5 text-center hover:bg-[#131747] hover:text-white transition">
                    Users
                    </Link>

                    <Link :href="route('admin.plans.index')"
                        class="rounded-2xl bg-[#F8F9FC] p-5 text-center hover:bg-[#131747] hover:text-white transition">
                    Plans
                    </Link>

                    <Link :href="route('admin.subscriptions.index')"
                        class="rounded-2xl bg-[#F8F9FC] p-5 text-center hover:bg-[#131747] hover:text-white transition">
                    Subscriptions
                    </Link>

                    <Link href="route('admin.settings')"
                        class="rounded-2xl bg-[#F8F9FC] p-5 text-center hover:bg-[#131747] hover:text-white transition">
                    Settings
                    </Link>

                </div>
            </div>

            <!-- System Status -->
            <div class="rounded-[2rem] border border-[#131747]/10 bg-white p-8">
                <h3 class="text-xl font-black text-[#131747]">
                    System Status
                </h3>

                <div class="mt-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <span>Stripe</span>

                        <span :class="stripeConfigured
                            ? 'text-green-600'
                            : 'text-red-500'">
                            {{ stripeConfigured ? 'Connected' : 'Setup Required' }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span>Plans</span>

                        <span class="text-green-600">
                            {{ stats.active_plans }} Active
                        </span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span>Admins</span>

                        <span class="text-[#131747]">
                            {{ stats.admins }}
                        </span>
                    </div>
                </div>
            </div>

        </div>

        <!-- Recent Activity Placeholder -->

        <div class="mt-8 rounded-[2rem] border border-[#131747]/10 bg-white p-8">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-black text-[#131747]">
                    Recent Activity
                </h3>

                <span class="text-sm text-[#131747]/50">
                    Coming Soon
                </span>
            </div>

            <p class="mt-4 text-[#131747]/60">
                User registrations, subscription changes, and payment activity will appear here.
            </p>

        </div>
    </AdminLayout>
</template>

<style>
    .animate-fade-in {
        animation: fadeIn 0.3s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(5px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
