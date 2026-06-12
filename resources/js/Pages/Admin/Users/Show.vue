<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    user: {
        type: Object,
        required: true,
    },

    subscriptions: {
        type: Array,
        default: () => [],
    },
});

const getStatusClass = (status) => {
    switch (status) {
        case 'active':
            return 'bg-green-100 text-green-700';

        case 'trialing':
            return 'bg-blue-100 text-blue-700';

        case 'past_due':
            return 'bg-yellow-100 text-yellow-700';

        case 'canceled':
            return 'bg-red-100 text-red-700';

        default:
            return 'bg-gray-100 text-gray-700';
    }
};
</script>

<template>
    <Head :title="`${user.name} | User Profile`" />

    <AdminLayout>

        <template #header>
            <div>
                <p
                    class="text-xs font-semibold uppercase tracking-[0.3em] text-[#FF4040]"
                >
                    User Management
                </p>

                <h1
                    class="mt-2 text-4xl font-black tracking-tight text-[#131747]"
                >
                    User Profile
                </h1>

                <p
                    class="mt-2 text-[#131747]/60"
                >
                    View account details, subscriptions, and user information.
                </p>
            </div>
        </template>

        <div class="py-10">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-8">

                <!-- User Hero -->
                <div
                    class="relative overflow-hidden rounded-[2rem] bg-[#131747] p-8 text-white shadow-xl"
                >
                    <div
                        class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(255,64,64,0.25),_transparent_50%)]"
                    ></div>

                    <div
                        class="relative flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between"
                    >
                        <div
                            class="flex items-center gap-5"
                        >
                            <div
                                class="flex h-20 w-20 items-center justify-center rounded-full bg-white/10 text-3xl font-black"
                            >
                                {{ user.name?.charAt(0)?.toUpperCase() }}
                            </div>

                            <div>

                                <span
                                    class="inline-flex rounded-full bg-white/10 px-3 py-1 text-[10px] font-bold uppercase tracking-widest"
                                >
                                    {{ user.role }}
                                </span>

                                <h2
                                    class="mt-3 text-3xl font-black"
                                >
                                    {{ user.name }}
                                </h2>

                                <p
                                    class="mt-1 text-white/70"
                                >
                                    {{ user.email }}
                                </p>

                            </div>
                        </div>

                        <div
                            class="flex flex-wrap gap-3"
                        >
                            <Link
                                :href="route('admin.users.edit', user.id)"
                                class="rounded-xl bg-[#FF4040] px-6 py-3 text-sm font-bold text-white transition hover:bg-white hover:text-[#131747]"
                            >
                                Edit User
                            </Link>

                            <Link
                                :href="route('admin.users.index')"
                                class="rounded-xl border border-white/20 px-6 py-3 text-sm font-bold text-white transition hover:bg-white/10"
                            >
                                Back to Users
                            </Link>
                        </div>
                    </div>
                </div>

                <!-- Overview Cards -->
                <div class="grid gap-6 md:grid-cols-3">

                    <div
                        class="rounded-[1.75rem] border border-[#131747]/10 bg-white p-6 shadow-sm"
                    >
                        <p
                            class="text-xs font-bold uppercase tracking-widest text-[#131747]/40"
                        >
                            Subscription Plan
                        </p>

                        <h3
                            class="mt-3 text-2xl font-black text-[#131747]"
                        >
                            {{ user.subscription?.plan_name || 'No Plan' }}
                        </h3>
                    </div>

                    <div
                        class="rounded-[1.75rem] border border-[#131747]/10 bg-white p-6 shadow-sm"
                    >
                        <p
                            class="text-xs font-bold uppercase tracking-widest text-[#131747]/40"
                        >
                            Subscription Status
                        </p>

                        <div
                            class="mt-3"
                        >
                            <span
                                class="rounded-full px-3 py-1 text-xs font-bold uppercase tracking-widest"
                                :class="getStatusClass(user.subscription?.status)"
                            >
                                {{ user.subscription?.status || 'inactive' }}
                            </span>
                        </div>
                    </div>

                    <div
                        class="rounded-[1.75rem] border border-[#131747]/10 bg-white p-6 shadow-sm"
                    >
                        <p
                            class="text-xs font-bold uppercase tracking-widest text-[#131747]/40"
                        >
                            Company
                        </p>

                        <h3
                            class="mt-3 text-2xl font-black text-[#131747]"
                        >
                            {{ user.company_name || 'Not Provided' }}
                        </h3>
                    </div>

                </div>

                <!-- Content -->
                <div class="grid gap-8 lg:grid-cols-3">

                    <!-- Account Details -->
                    <div
                        class="lg:col-span-2 rounded-[2rem] border border-[#131747]/10 bg-white p-8 shadow-sm"
                    >
                        <h3
                            class="text-xl font-black text-[#131747]"
                        >
                            Account Details
                        </h3>

                        <div
                            class="mt-8 grid gap-6 md:grid-cols-2"
                        >

                            <div>
                                <p
                                    class="text-sm text-[#131747]/50"
                                >
                                    Full Name
                                </p>

                                <p
                                    class="mt-1 font-bold text-[#131747]"
                                >
                                    {{ user.name }}
                                </p>
                            </div>

                            <div>
                                <p
                                    class="text-sm text-[#131747]/50"
                                >
                                    Email Address
                                </p>

                                <p
                                    class="mt-1 font-bold text-[#131747]"
                                >
                                    {{ user.email }}
                                </p>
                            </div>

                            <div>
                                <p
                                    class="text-sm text-[#131747]/50"
                                >
                                    Phone Number
                                </p>

                                <p
                                    class="mt-1 font-bold text-[#131747]"
                                >
                                    {{ user.phone || 'Not Provided' }}
                                </p>
                            </div>

                            <div>
                                <p
                                    class="text-sm text-[#131747]/50"
                                >
                                    Role
                                </p>

                                <p
                                    class="mt-1 font-bold text-[#131747]"
                                >
                                    {{ user.role }}
                                </p>
                            </div>

                            <div>
                                <p
                                    class="text-sm text-[#131747]/50"
                                >
                                    Company
                                </p>

                                <p
                                    class="mt-1 font-bold text-[#131747]"
                                >
                                    {{ user.company_name || 'Not Provided' }}
                                </p>
                            </div>

                            <div v-if="user.created_at">
                                <p
                                    class="text-sm text-[#131747]/50"
                                >
                                    Member Since
                                </p>

                                <p
                                    class="mt-1 font-bold text-[#131747]"
                                >
                                    {{ user.created_at }}
                                </p>
                            </div>

                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="space-y-6">

                        <div
                            class="rounded-[2rem] border border-[#131747]/10 bg-white p-8 shadow-sm"
                        >
                            <h3
                                class="text-lg font-black text-[#131747]"
                            >
                                Account Summary
                            </h3>

                            <div
                                class="mt-6 space-y-4"
                            >

                                <div
                                    class="flex items-center justify-between"
                                >
                                    <span class="text-[#131747]/60">
                                        User ID
                                    </span>

                                    <span class="font-bold text-[#131747]">
                                        #{{ user.id }}
                                    </span>
                                </div>

                                <div
                                    class="flex items-center justify-between"
                                >
                                    <span class="text-[#131747]/60">
                                        Role
                                    </span>

                                    <span class="font-bold capitalize text-[#131747]">
                                        {{ user.role }}
                                    </span>
                                </div>

                                <div
                                    class="flex items-center justify-between"
                                >
                                    <span class="text-[#131747]/60">
                                        Plan
                                    </span>

                                    <span class="font-bold text-[#131747]">
                                        {{ user.subscription?.plan_name || 'None' }}
                                    </span>
                                </div>

                            </div>
                        </div>

                        <div
                            class="rounded-[2rem] border border-[#FF4040]/10 bg-[#FF4040]/5 p-6"
                        >
                            <h3
                                class="font-black text-[#131747]"
                            >
                                Administrator Note
                            </h3>

                            <p
                                class="mt-3 text-sm leading-6 text-[#131747]/70"
                            >
                                Review user information and subscription details
                                before making account changes.
                            </p>
                        </div>

                    </div>

                </div>

                <!-- Subscription History -->
                <div
                    class="rounded-[2rem] border border-[#131747]/10 bg-white p-8 shadow-sm"
                >

                    <div
                        class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between"
                    >
                        <div>
                            <h3
                                class="text-xl font-black text-[#131747]"
                            >
                                Subscription History
                            </h3>

                            <p
                                class="mt-1 text-sm text-[#131747]/50"
                            >
                                Previous and current subscription records.
                            </p>
                        </div>

                        <span
                            class="text-sm font-bold text-[#131747]/50"
                        >
                            {{ subscriptions.length }} Records
                        </span>
                    </div>

                    <div
                        class="mt-8 space-y-4"
                    >

                        <div
                            v-for="subscription in subscriptions"
                            :key="subscription.id"
                            class="rounded-xl border border-[#131747]/10 p-5 transition hover:border-[#131747]/20"
                        >
                            <div
                                class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between"
                            >

                                <div>
                                    <h4
                                        class="font-bold text-[#131747]"
                                    >
                                        {{ subscription.plan || 'Unknown Plan' }}
                                    </h4>

                                    <p
                                        class="mt-1 text-sm text-[#131747]/50"
                                    >
                                        {{
                                            subscription.price_ids?.length
                                                ? subscription.price_ids.join(', ')
                                                : 'No Price IDs'
                                        }}
                                    </p>
                                </div>

                                <span
                                    class="w-fit rounded-full px-3 py-1 text-xs font-bold uppercase tracking-widest"
                                    :class="getStatusClass(subscription.status)"
                                >
                                    {{ subscription.status }}
                                </span>

                            </div>
                        </div>

                        <div
                            v-if="!subscriptions.length"
                            class="py-12 text-center"
                        >
                            <p
                                class="font-medium text-[#131747]/50"
                            >
                                No subscription history found.
                            </p>
                        </div>

                    </div>

                </div>

            </div>
        </div>

    </AdminLayout>
</template>