<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import {
    CreditCard,
    Calendar,
    CheckCircle2,
    Pencil,
} from 'lucide-vue-next';

const props = defineProps({
    plan: {
        type: Object,
        required: true,
    },

    tools: {
        type: Array,
        default: () => [],
    },
});
</script>

<template>
    <Head :title="`${plan.name} Plan`" />

    <AdminLayout>

        <template #header>
            <div>
                <p
                    class="text-xs font-semibold uppercase tracking-[0.3em] text-[#FF4040]"
                >
                    Subscription Management
                </p>

                <h1
                    class="mt-2 text-4xl font-black text-[#131747]"
                >
                    {{ plan.name }}
                </h1>

                <p
                    class="mt-2 text-[#131747]/60"
                >
                    View pricing, calculator access, and plan configuration.
                </p>
            </div>
        </template>

        <div class="space-y-8">

            <!-- Hero -->
            <div
                class="relative overflow-hidden rounded-[2rem] bg-[#131747] p-8 text-white shadow-xl"
            >
                <div
                    class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(255,64,64,0.25),_transparent_50%)]"
                />

                <div
                    class="relative flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between"
                >
                    <div>

                        <span
                            class="inline-flex rounded-full bg-white/10 px-3 py-1 text-[10px] font-bold uppercase tracking-widest"
                        >
                            {{ plan.slug }}
                        </span>

                        <h2
                            class="mt-4 text-4xl font-black"
                        >
                            {{ plan.name }}
                        </h2>

                        <p
                            class="mt-3 max-w-2xl text-white/70"
                        >
                            {{ plan.description }}
                        </p>

                    </div>

                    <div
                        class="flex gap-3"
                    >
                        <Link
                            :href="route('admin.plans.index')"
                            class="rounded-xl border border-white/20 px-6 py-3 text-sm font-bold text-white transition hover:bg-white/10"
                        >
                            Back
                        </Link>

                        <Link
                            :href="route('admin.plans.edit', plan.id)"
                            class="inline-flex items-center gap-2 rounded-xl bg-[#FF4040] px-6 py-3 text-sm font-bold text-white transition hover:bg-white hover:text-[#131747]"
                        >
                            <Pencil class="h-4 w-4" />
                            Edit Plan
                        </Link>
                    </div>
                </div>
            </div>

            <!-- Stats -->
            <div class="grid gap-6 md:grid-cols-3">

                <div
                    class="rounded-[1.75rem] border border-[#131747]/10 bg-white p-6 shadow-sm"
                >
                    <CreditCard class="h-6 w-6 text-[#FF4040]" />

                    <p
                        class="mt-4 text-xs font-bold uppercase tracking-widest text-[#131747]/40"
                    >
                        Monthly Price
                    </p>

                    <h3
                        class="mt-2 text-3xl font-black text-[#131747]"
                    >
                        {{ plan.monthly_price_display || 'N/A' }}
                    </h3>
                </div>

                <div
                    class="rounded-[1.75rem] border border-[#131747]/10 bg-white p-6 shadow-sm"
                >
                    <Calendar class="h-6 w-6 text-[#FF4040]" />

                    <p
                        class="mt-4 text-xs font-bold uppercase tracking-widest text-[#131747]/40"
                    >
                        Yearly Price
                    </p>

                    <h3
                        class="mt-2 text-3xl font-black text-[#131747]"
                    >
                        {{ plan.yearly_price_display || 'N/A' }}
                    </h3>
                </div>

                <div
                    class="rounded-[1.75rem] border border-[#131747]/10 bg-white p-6 shadow-sm"
                >
                    <CheckCircle2 class="h-6 w-6 text-[#FF4040]" />

                    <p
                        class="mt-4 text-xs font-bold uppercase tracking-widest text-[#131747]/40"
                    >
                        Status
                    </p>

                    <div class="mt-3">
                        <span
                            class="rounded-full px-3 py-1 text-xs font-bold uppercase tracking-widest"
                            :class="
                                plan.is_active
                                    ? 'bg-green-100 text-green-700'
                                    : 'bg-red-100 text-red-700'
                            "
                        >
                            {{ plan.is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>

            </div>

            <!-- Main Content -->
            <div class="grid gap-8 lg:grid-cols-3">

                <!-- Calculators -->
                <div class="lg:col-span-2">

                    <div
                        class="rounded-[2rem] border border-[#131747]/10 bg-white p-8 shadow-sm"
                    >
                        <h3
                            class="text-xl font-black text-[#131747]"
                        >
                            Included Calculators
                        </h3>

                        <p
                            class="mt-2 text-sm text-[#131747]/50"
                        >
                            Calculators available to users subscribed to this plan.
                        </p>

                        <div
                            class="mt-8 grid gap-4 md:grid-cols-2"
                        >

                            <div
                                v-for="tool in tools"
                                :key="tool.id"
                                class="rounded-xl border border-[#131747]/10 bg-[#131747]/5 p-4 transition hover:border-[#131747]/20"
                            >
                                <p
                                    class="font-bold text-[#131747]"
                                >
                                    {{ tool.title }}
                                </p>
                            </div>

                            <div
                                v-if="!tools.length"
                                class="rounded-xl border border-dashed border-[#131747]/20 p-6 text-center"
                            >
                                <p
                                    class="text-sm text-[#131747]/50"
                                >
                                    No calculators assigned to this plan.
                                </p>
                            </div>

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
                            Plan Summary
                        </h3>

                        <div
                            class="mt-6 space-y-4"
                        >

                            <div
                                class="flex items-center justify-between"
                            >
                                <span class="text-[#131747]/50">
                                    Plan ID
                                </span>

                                <span class="font-bold text-[#131747]">
                                    #{{ plan.id }}
                                </span>
                            </div>

                            <div
                                class="flex items-center justify-between"
                            >
                                <span class="text-[#131747]/50">
                                    Slug
                                </span>

                                <span class="font-bold text-[#131747]">
                                    {{ plan.slug }}
                                </span>
                            </div>

                            <div
                                class="flex items-center justify-between"
                            >
                                <span class="text-[#131747]/50">
                                    Calculators
                                </span>

                                <span class="font-bold text-[#131747]">
                                    {{ tools.length }}
                                </span>
                            </div>

                            <div
                                class="flex items-center justify-between"
                            >
                                <span class="text-[#131747]/50">
                                    Active
                                </span>

                                <span
                                    class="font-bold"
                                    :class="
                                        plan.is_active
                                            ? 'text-green-600'
                                            : 'text-red-600'
                                    "
                                >
                                    {{ plan.is_active ? 'Yes' : 'No' }}
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
                            Changes made to this plan may affect current and future
                            subscribers. Review pricing and calculator access
                            carefully before making updates.
                        </p>
                    </div>

                </div>

            </div>

        </div>

    </AdminLayout>
</template>