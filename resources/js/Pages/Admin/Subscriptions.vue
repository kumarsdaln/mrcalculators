<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import AdminNav from '@/Components/AdminNav.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    subscriptions: {
        type: Array,
        required: true,
    },
    pagination: {
        type: Object,
        required: true,
    }
});
</script>

<template>
    <Head title="Admin Subscriptions" />

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
                
                <AdminNav active="Subscriptions" />

                <!-- SUBSCRIPTIONS TAB -->
                <div class="space-y-8 animate-fade-in">
                    <div class="rounded-[1.75rem] border border-[#131747]/10 bg-white p-8 shadow-sm shadow-[#131747]/5">
                        <div class="mb-8 border-b border-[#131747]/10 pb-4 flex justify-between items-end">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-[#FF4040]">
                                    Billing Ledgers
                                </p>
                                <h3 class="mt-2 text-2xl font-bold text-[#131747]">Recent Subscriptions & Trials</h3>
                            </div>
                            <p class="text-xs font-bold text-[#131747]/40 uppercase tracking-widest">Showing page {{ pagination.current_page }} of {{ pagination.last_page }}</p>
                        </div>

                        <div class="grid gap-4 lg:grid-cols-2">
                            <div
                                v-for="subscription in subscriptions"
                                :key="subscription.id"
                                class="rounded-[1.5rem] border border-[#131747]/10 bg-white p-6 shadow-sm flex flex-col relative overflow-hidden"
                            >
                                <!-- Status Line indicator -->
                                <div class="absolute inset-y-0 left-0 w-1" :class="subscription.status === 'active' ? 'bg-[#131747]' : 'bg-[#FF4040]'"></div>

                                <div class="flex justify-between items-start pl-2 mb-4 pb-4 border-b border-[#131747]/5">
                                    <div>
                                        <p class="text-base font-bold text-[#131747]">{{ subscription.user.name }}</p>
                                        <p class="text-xs text-[#131747]/50 font-mono">{{ subscription.user.email }}</p>
                                    </div>
                                    <span class="rounded-lg px-3 py-1.5 text-[10px] font-bold uppercase tracking-widest shadow-sm" :class="subscription.status === 'active' ? 'bg-[#131747] text-white' : 'bg-[#FF4040]/10 text-[#FF4040]'">
                                        {{ subscription.status }}
                                    </span>
                                </div>
                                <div class="pl-2 space-y-2">
                                    <div class="flex justify-between items-center bg-[#131747]/5 p-2 rounded-lg">
                                        <p class="text-[10px] font-bold uppercase tracking-wide text-[#131747]/60">Tier / Frequency</p>
                                        <p class="text-xs font-bold text-[#131747]">{{ subscription.plan || 'Unmapped' }} | <span class="capitalize">{{ subscription.interval || 'N/A' }}</span></p>
                                    </div>
                                    <div class="flex justify-between items-center px-2 pt-2">
                                        <p class="text-[10px] font-bold uppercase tracking-wide text-[#131747]/40">Stripe Objects</p>
                                        <p class="text-[10px] font-mono text-[#131747]/50 truncate max-w-[150px]" :title="subscription.price_ids.join(', ')">
                                            {{ subscription.price_ids.length ? subscription.price_ids[0] + '...' : 'n/a' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div v-if="!subscriptions.length" class="text-center py-12">
                            <p class="text-[#131747]/40 font-bold uppercase tracking-widest text-sm">No subscription records found in the database.</p>
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
