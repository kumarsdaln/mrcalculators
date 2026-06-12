<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import {
    CreditCard,
    Star,
    Users,
    Calculator,
    Plus
} from 'lucide-vue-next';

const props = defineProps({
    plans: {
        type: Array,
        required: true,
    },
});

const formatPrice = (price) => {
    if (!price) return '0';
    return Number(price).toFixed(0);
};
</script>

<template>
    <Head title="Plans" />

    <AdminLayout>

        <template #header>
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

                <div>
                    <p
                        class="text-xs font-semibold uppercase tracking-[0.3em] text-[#FF4040]"
                    >
                        Subscription Management
                    </p>

                    <h1
                        class="mt-2 text-4xl font-black text-[#131747]"
                    >
                        Plans
                    </h1>

                    <p
                        class="mt-2 text-[#131747]/60"
                    >
                        Manage subscription plans, pricing, and calculator access.
                    </p>
                </div>

                <Link
                    :href="route('admin.plans.create')"
                    class="inline-flex items-center gap-2 rounded-xl bg-[#131747] px-6 py-3 font-bold text-white transition hover:bg-[#FF4040]"
                >
                    <Plus class="h-4 w-4" />
                    Create Plan
                </Link>

            </div>
        </template>

        <div class="space-y-8">

            <!-- Stats -->
            <div class="grid gap-6 md:grid-cols-4">

                <div class="rounded-[1.5rem] border border-[#131747]/10 bg-white p-6">
                    <CreditCard class="h-6 w-6 text-[#FF4040]" />

                    <p class="mt-4 text-sm text-[#131747]/50">
                        Total Plans
                    </p>

                    <h3 class="mt-2 text-3xl font-black text-[#131747]">
                        {{ plans.length }}
                    </h3>
                </div>

                <div class="rounded-[1.5rem] border border-[#131747]/10 bg-white p-6">
                    <Star class="h-6 w-6 text-[#FF4040]" />

                    <p class="mt-4 text-sm text-[#131747]/50">
                        Featured Plans
                    </p>

                    <h3 class="mt-2 text-3xl font-black text-[#131747]">
                        {{ plans.filter(p => p.is_featured).length }}
                    </h3>
                </div>

                <div class="rounded-[1.5rem] border border-[#131747]/10 bg-white p-6">
                    <Users class="h-6 w-6 text-[#FF4040]" />

                    <p class="mt-4 text-sm text-[#131747]/50">
                        Active Plans
                    </p>

                    <h3 class="mt-2 text-3xl font-black text-[#131747]">
                        {{ plans.filter(p => p.is_active).length }}
                    </h3>
                </div>

                <div class="rounded-[1.5rem] border border-[#131747]/10 bg-white p-6">
                    <Calculator class="h-6 w-6 text-[#FF4040]" />

                    <p class="mt-4 text-sm text-[#131747]/50">
                        Calculator Access
                    </p>

                    <h3 class="mt-2 text-3xl font-black text-[#131747]">
                        5
                    </h3>
                </div>

            </div>

            <!-- Plans -->
            <div>

                <div class="mb-6">
                    <h2
                        class="text-2xl font-black text-[#131747]"
                    >
                        Subscription Plans
                    </h2>

                    <p
                        class="mt-1 text-[#131747]/50"
                    >
                        Manage pricing and access levels for your users.
                    </p>
                </div>

                <div
                    v-if="plans.length"
                    class="grid gap-6 md:grid-cols-2 xl:grid-cols-3"
                >

                    <div
                        v-for="plan in plans"
                        :key="plan.id"
                        class="rounded-[2rem] border border-[#131747]/10 bg-white p-8 shadow-sm transition hover:-translate-y-1 hover:shadow-lg"
                    >

                        <div class="flex items-start justify-between">

                            <div>
                                <h3
                                    class="text-2xl font-black text-[#131747]"
                                >
                                    {{ plan.name }}
                                </h3>

                                <p
                                    class="mt-2 text-sm text-[#131747]/60"
                                >
                                    {{ plan.description }}
                                </p>
                            </div>

                            <span
                                v-if="plan.is_featured"
                                class="rounded-full bg-[#FF4040]/10 px-3 py-1 text-xs font-bold text-[#FF4040]"
                            >
                                Featured
                            </span>

                        </div>

                        <div class="mt-8">

                            <span
                                class="text-5xl font-black text-[#131747]"
                            >
                                ${{ formatPrice(plan.monthly_price) }}
                            </span>

                            <span
                                class="text-[#131747]/50"
                            >
                                /month
                            </span>

                        </div>

                        <div class="mt-6">

                            <div
                                class="flex flex-wrap gap-2"
                            >

                                <span
                                    v-for="tool in (plan.tool_access || []).slice(0, 4)"
                                    :key="tool"
                                    class="rounded-full bg-[#131747]/5 px-3 py-1 text-xs font-bold text-[#131747]"
                                >
                                    {{ tool }}
                                </span>

                                <span
                                    v-if="(plan.tool_access || []).length > 4"
                                    class="rounded-full bg-[#FF4040]/10 px-3 py-1 text-xs font-bold text-[#FF4040]"
                                >
                                    +{{ plan.tool_access.length - 4 }}
                                </span>

                            </div>

                        </div>

                        <div class="mt-8 flex gap-3">

                            <Link
                                :href="route('admin.plans.show', plan.id)"
                                class="flex-1 rounded-xl border border-[#131747]/10 px-4 py-3 text-center text-sm font-bold text-[#131747] transition hover:border-[#131747]"
                            >
                                View
                            </Link>

                            <Link
                                :href="route('admin.plans.edit', plan.id)"
                                class="flex-1 rounded-xl bg-[#131747] px-4 py-3 text-center text-sm font-bold text-white transition hover:bg-[#FF4040]"
                            >
                                Edit
                            </Link>

                        </div>

                    </div>

                </div>

                <div
                    v-else
                    class="rounded-[2rem] border border-dashed border-[#131747]/20 bg-white p-16 text-center"
                >

                    <h3
                        class="text-2xl font-black text-[#131747]"
                    >
                        No Plans Found
                    </h3>

                    <p
                        class="mt-3 text-[#131747]/50"
                    >
                        Create your first subscription plan to get started.
                    </p>

                    <Link
                        :href="route('admin.plans.create')"
                        class="mt-6 inline-flex rounded-xl bg-[#131747] px-6 py-3 font-bold text-white hover:bg-[#FF4040]"
                    >
                        Create Plan
                    </Link>

                </div>

            </div>

        </div>

    </AdminLayout>
</template>