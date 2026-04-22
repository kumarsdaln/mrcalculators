<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import AdminNav from '@/Components/AdminNav.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import { reactive } from 'vue';

const props = defineProps({
    plans: {
        type: Array,
        required: true,
    },
    availableFeatures: {
        type: Array,
        required: true,
    }
});

const blankPlan = () => ({
    name: '',
    slug: '',
    description: '',
    monthly_price: '',
    yearly_price: '',
    currency: 'USD',
    trial_days: 0,
    stripe_product_id: '',
    stripe_price_id_monthly: '',
    stripe_price_id_yearly: '',
    is_active: true,
    is_featured: false,
    sort_order: 0,
    feature_access: [],
});

const newPlan = useForm(blankPlan());
const editablePlans = reactive(
    props.plans.map((plan) => ({
        ...plan,
        currency: plan.currency || 'USD',
        feature_access: [...plan.feature_access],
    })),
);

const toggleFeature = (features, slug) => {
    const index = features.indexOf(slug);

    if (index === -1) {
        features.push(slug);
        return;
    }

    features.splice(index, 1);
};

const submitNewPlan = () => {
    newPlan.post(route('admin.plans.store'), {
        preserveScroll: true,
        onSuccess: () => newPlan.reset(),
    });
};

const savePlan = (plan) => {
    router.patch(route('admin.plans.update', plan.id), plan, {
        preserveScroll: true,
    });
};
</script>

<template>
    <Head title="Admin Plans" />

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
                
                <AdminNav active="Plans" />

                <!-- PLANS TAB -->
                <div class="space-y-8 animate-fade-in">
                    
                    <div class="rounded-[1.75rem] border border-[#131747]/10 bg-white p-8 shadow-sm shadow-[#131747]/5">
                        <div class="mb-8 border-b border-[#131747]/10 pb-4 flex justify-between items-end">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-[#FF4040]">
                                    Tier Management
                                </p>
                                <h3 class="mt-2 text-2xl font-bold text-[#131747]">Create New Subscription Plan</h3>
                            </div>
                        </div>

                        <form class="space-y-6" @submit.prevent="submitNewPlan">
                            <div class="grid gap-6 md:grid-cols-2">
                                <div class="md:col-span-2">
                                    <label class="text-xs font-bold uppercase tracking-wider text-[#131747]/60">Plan Name</label>
                                    <input v-model="newPlan.name" type="text" class="mt-2 w-full rounded-xl border border-[#131747]/12 py-3 px-4 text-[#131747] font-bold focus:border-[#FF4040]/40 focus:ring-2 focus:ring-[#FF4040]/15" />
                                </div>
                                <div>
                                    <label class="text-xs font-bold uppercase tracking-wider text-[#131747]/60">System Slug</label>
                                    <input v-model="newPlan.slug" type="text" class="mt-2 w-full rounded-xl border border-[#131747]/12 py-3 px-4 font-mono text-sm text-[#131747] focus:border-[#FF4040]/40 focus:ring-2 focus:ring-[#FF4040]/15" />
                                </div>
                                <div>
                                    <label class="text-xs font-bold uppercase tracking-wider text-[#131747]/60">Trial Days</label>
                                    <input v-model.number="newPlan.trial_days" type="number" min="0" class="mt-2 w-full rounded-xl border border-[#131747]/12 py-3 px-4 font-mono text-sm text-[#131747] focus:border-[#FF4040]/40 focus:ring-2 focus:ring-[#FF4040]/15" />
                                </div>
                                <div class="relative">
                                    <label class="text-xs font-bold uppercase tracking-wider text-[#131747]/60">Monthly Price ($)</label>
                                    <input v-model.number="newPlan.monthly_price" type="number" step="0.01" min="0" class="mt-2 w-full rounded-xl border border-[#131747]/12 py-3 px-4 font-mono font-bold text-lg text-[#131747] focus:border-[#FF4040]/40 focus:ring-2 focus:ring-[#FF4040]/15" />
                                </div>
                                <div class="relative">
                                    <label class="text-xs font-bold uppercase tracking-wider text-[#131747]/60">Yearly Price ($)</label>
                                    <input v-model.number="newPlan.yearly_price" type="number" step="0.01" min="0" class="mt-2 w-full rounded-xl border border-[#131747]/12 py-3 px-4 font-mono font-bold text-lg text-[#131747] focus:border-[#FF4040]/40 focus:ring-2 focus:ring-[#FF4040]/15" />
                                </div>
                                <div class="md:col-span-2">
                                    <label class="text-xs font-bold uppercase tracking-wider text-[#131747]/60">Marketing Description</label>
                                    <textarea v-model="newPlan.description" rows="3" class="mt-2 w-full rounded-xl border border-[#131747]/12 py-3 px-4 text-sm text-[#131747] focus:border-[#FF4040]/40 focus:ring-2 focus:ring-[#FF4040]/15"></textarea>
                                </div>
                            </div>

                            <div class="bg-[#131747]/[0.03] p-6 rounded-2xl border border-[#131747]/10 space-y-4">
                                <h4 class="text-xs font-bold uppercase tracking-wider text-[#131747]">Stripe Integrations</h4>
                                <div class="grid gap-4 md:grid-cols-3">
                                    <div>
                                        <label class="text-[10px] font-bold uppercase tracking-wider text-[#131747]/50">Product ID</label>
                                        <input v-model="newPlan.stripe_product_id" type="text" class="mt-1 w-full rounded-lg border border-[#131747]/12 py-2 px-3 font-mono text-xs text-[#131747]" placeholder="prod_..." />
                                    </div>
                                    <div>
                                        <label class="text-[10px] font-bold uppercase tracking-wider text-[#131747]/50">Monthly Price ID</label>
                                        <input v-model="newPlan.stripe_price_id_monthly" type="text" class="mt-1 w-full rounded-lg border border-[#131747]/12 py-2 px-3 font-mono text-xs text-[#131747]" placeholder="price_..." />
                                    </div>
                                    <div>
                                        <label class="text-[10px] font-bold uppercase tracking-wider text-[#131747]/50">Yearly Price ID</label>
                                        <input v-model="newPlan.stripe_price_id_yearly" type="text" class="mt-1 w-full rounded-lg border border-[#131747]/12 py-2 px-3 font-mono text-xs text-[#131747]" placeholder="price_..." />
                                    </div>
                                </div>
                            </div>

                            <div>
                                <p class="text-xs font-bold uppercase tracking-wider text-[#131747]/60">Feature Access Logic</p>
                                <div class="mt-3 grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                                    <button
                                        v-for="feature in availableFeatures"
                                        :key="feature.slug"
                                        type="button"
                                        class="rounded-xl border p-4 text-left transition"
                                        :class="
                                            newPlan.feature_access.includes(feature.slug)
                                                ? 'border-[#FF4040]/40 bg-[#FF4040]/10 ring-1 ring-[#FF4040]/20'
                                                : 'border-[#131747]/10 bg-white hover:border-[#131747]/30'
                                        "
                                        @click="toggleFeature(newPlan.feature_access, feature.slug)"
                                    >
                                        <p class="text-sm font-bold text-[#131747]">{{ feature.name }}</p>
                                        <p class="mt-1 text-xs leading-snug text-[#131747]/50">{{ feature.description }}</p>
                                    </button>
                                </div>
                            </div>

                            <div class="flex flex-wrap gap-4 pt-4 border-t border-[#131747]/10">
                                <label class="cursor-pointer inline-flex items-center gap-3 rounded-xl border border-[#131747]/10 bg-[#131747]/5 px-5 py-3 text-sm font-bold uppercase tracking-wider text-[#131747] hover:bg-[#131747]/10 transition">
                                    <input v-model="newPlan.is_active" type="checkbox" class="rounded border-[#131747]/30 text-[#FF4040] focus:ring-[#FF4040]" />
                                    Is Active
                                </label>
                                <label class="cursor-pointer inline-flex items-center gap-3 rounded-xl border border-[#131747]/10 bg-[#131747]/5 px-5 py-3 text-sm font-bold uppercase tracking-wider text-[#131747] hover:bg-[#131747]/10 transition">
                                    <input v-model="newPlan.is_featured" type="checkbox" class="rounded border-[#131747]/30 text-[#FF4040] focus:ring-[#FF4040]" />
                                    Is Featured
                                </label>
                            </div>

                            <div class="pt-4">
                                <PrimaryButton :disabled="newPlan.processing" class="px-8 py-4 w-full justify-center md:w-auto">Confirm & Create Plan</PrimaryButton>
                            </div>
                        </form>
                    </div>

                    <!-- Existing Plans Edit -->
                    <div class="space-y-6">
                        <h3 class="text-xl font-bold text-[#131747] mt-12 mb-6">Active Plans Catalogue</h3>
                        
                        <div class="grid gap-6 xl:grid-cols-2">
                            <div
                                v-for="plan in editablePlans"
                                :key="plan.id"
                                class="rounded-[1.5rem] border border-[#131747]/10 bg-white p-6 md:p-8 shadow-sm flex flex-col"
                            >
                                <div class="flex justify-between items-start mb-6 pb-4 border-b border-[#131747]/10">
                                    <div class="flex-1">
                                        <input v-model="plan.name" type="text" class="w-full text-xl font-extrabold text-[#131747] border-none bg-transparent p-0 focus:ring-0 placeholder:text-[#131747]/20" placeholder="Plan Name" />
                                        <input v-model="plan.slug" type="text" class="w-full text-xs font-mono text-[#131747]/50 border-none bg-transparent p-0 focus:ring-0 uppercase tracking-widest mt-1" />
                                    </div>
                                    <div class="flex gap-2">
                                        <label class="flex items-center text-[10px] uppercase font-bold text-[#131747]/50 gap-1 cursor-pointer">
                                            <input v-model="plan.is_active" type="checkbox" class="rounded text-[#131747] border-[#131747]/30"> Act
                                        </label>
                                        <label class="flex items-center text-[10px] uppercase font-bold text-[#FF4040] gap-1 cursor-pointer">
                                            <input v-model="plan.is_featured" type="checkbox" class="rounded text-[#FF4040] border-[#FF4040]/30"> Feat
                                        </label>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4 mb-6">
                                    <div>
                                        <label class="text-[10px] font-bold uppercase tracking-wider text-[#131747]/50">Monthly Price</label>
                                        <div class="flex items-center gap-1">
                                            <span class="text-[#131747]/40 font-bold">$</span>
                                            <input v-model.number="plan.monthly_price" type="number" step="0.01" class="w-full border-b border-[#131747]/10 bg-transparent py-1 px-0 font-mono font-bold text-[#131747] focus:border-[#FF4040] focus:ring-0" />
                                        </div>
                                    </div>
                                    <div>
                                        <label class="text-[10px] font-bold uppercase tracking-wider text-[#131747]/50">Yearly Price</label>
                                        <div class="flex items-center gap-1">
                                            <span class="text-[#131747]/40 font-bold">$</span>
                                            <input v-model.number="plan.yearly_price" type="number" step="0.01" class="w-full border-b border-[#131747]/10 bg-transparent py-1 px-0 font-mono font-bold text-[#131747] focus:border-[#FF4040] focus:ring-0" />
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-6">
                                    <label class="text-[10px] font-bold uppercase tracking-wider text-[#131747]/50">Description</label>
                                    <textarea v-model="plan.description" rows="2" class="w-full mt-1 rounded-lg border border-[#131747]/10 bg-transparent p-3 text-sm text-[#131747]"></textarea>
                                </div>

                                <div class="bg-[#131747]/[0.02] p-4 rounded-xl border border-[#131747]/5 mb-6">
                                    <p class="text-[10px] font-bold uppercase tracking-wider text-[#131747]/70 mb-3">Feature Rules</p>
                                    <div class="flex flex-wrap gap-2">
                                        <button
                                            v-for="feature in availableFeatures"
                                            :key="`${plan.id}-${feature.slug}`"
                                            type="button"
                                            class="rounded-lg px-3 py-1.5 text-xs font-bold transition flex items-center gap-1"
                                            :class="
                                                plan.feature_access.includes(feature.slug)
                                                    ? 'bg-[#131747] text-white'
                                                    : 'bg-white border border-[#131747]/10 text-[#131747]/40 hover:text-[#131747]/80'
                                            "
                                            @click="toggleFeature(plan.feature_access, feature.slug)"
                                        >
                                            <span v-if="plan.feature_access.includes(feature.slug)" class="w-1.5 h-1.5 rounded-full bg-[#FF4040]"></span>
                                            {{ feature.name }}
                                        </button>
                                    </div>
                                </div>

                                <div class="mt-auto flex justify-end">
                                    <SecondaryButton type="button" @click="savePlan(plan)" class="text-xs uppercase tracking-widest px-6 py-2">Save Updates</SecondaryButton>
                                </div>
                            </div>
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
