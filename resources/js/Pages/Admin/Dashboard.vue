<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import AdminNav from '@/Components/AdminNav.vue';
import { Head } from '@inertiajs/vue3';

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

    <AuthenticatedLayout>
        <template #header>
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-[#FF4040]">
                    Operations workspace
                </p>
                <h2 class="mt-2 text-2xl font-bold leading-tight text-[#131747]">
                    Admin Command Center
                </h2>
            </div>
        </template>

        <div class="py-10">
            <div class="mx-auto max-w-7xl space-y-8 px-4 sm:px-6 lg:px-8">
                
                <AdminNav active="Overview" />

                <!-- OVERVIEW TAB -->
                <div class="space-y-8 animate-fade-in">
                    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                        <div class="rounded-[1.5rem] border border-[#131747]/10 bg-white p-6 shadow-sm shadow-[#131747]/5">
                            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-[#131747]/45">Total Users</p>
                            <p class="mt-3 text-4xl font-extrabold text-[#131747]">{{ stats.users }}</p>
                        </div>
                        <div class="rounded-[1.5rem] border border-[#131747]/10 bg-white p-6 shadow-sm shadow-[#131747]/5">
                            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-[#131747]/45">System Admins</p>
                            <p class="mt-3 text-4xl font-extrabold text-[#131747]">{{ stats.admins }}</p>
                        </div>
                        <div class="rounded-[1.5rem] border border-[#131747]/10 bg-[#131747] text-white p-6 shadow-lg shadow-[#131747]/10 relative overflow-hidden">
                            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(255,64,64,0.3),_transparent_60%)]"></div>
                            <div class="relative z-10">
                                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-white/50">Active Subscribers</p>
                                <p class="mt-3 text-4xl font-extrabold">{{ stats.active_subscribers }}</p>
                            </div>
                        </div>
                        <div class="rounded-[1.5rem] border border-[#131747]/10 bg-white p-6 shadow-sm shadow-[#131747]/5">
                            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-[#FF4040]/70">Past Due Accounts</p>
                            <p class="mt-3 text-4xl font-extrabold text-[#131747]">{{ stats.past_due_subscribers }}</p>
                        </div>
                        <div class="rounded-[1.5rem] border border-[#131747]/10 bg-white p-6 shadow-sm shadow-[#131747]/5">
                            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-[#131747]/45">Live Plans</p>
                            <p class="mt-3 text-4xl font-extrabold text-[#131747]">{{ stats.active_plans }}</p>
                        </div>
                        <div class="rounded-[1.5rem] border border-[#FF4040]/30 bg-[#FF4040]/5 p-6 shadow-sm">
                            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-[#FF4040]">MRR Estimate</p>
                            <p class="mt-3 text-4xl font-extrabold text-[#FF4040]">{{ stats.mrr_estimate }}</p>
                        </div>
                    </div>

                    <div
                        v-if="!stripeConfigured"
                        class="rounded-[1.75rem] border border-[#FF4040]/20 bg-[#FF4040]/8 p-6 text-sm leading-6 text-[#131747]/75 flex items-start gap-4"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#FF4040] shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                        <div>
                            <p class="font-bold text-[#131747] mb-1 text-base">Stripe Inactive</p>
                            <p>Stripe is not fully configured yet. You can manage plans and roles here now, then add live Stripe keys and price IDs to your <code>.env</code> file to activate checkout workflows automatically.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style>
.animate-fade-in {
    animation: fadeIn 0.3s ease-in-out;
}
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(5px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
