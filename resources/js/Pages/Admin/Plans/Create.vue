<script setup>
    import AdminLayout from '@/Layouts/AdminLayout.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import { Head, Link, useForm } from '@inertiajs/vue3';
    import {
        DollarSign,
        Calculator,
        Package,
        CreditCard
    } from 'lucide-vue-next';

    const props = defineProps({
        availableFeatures: Array,
        availableTools: Array,
    });

    const form = useForm({
        name: '',
        slug: '',
        description: '',
        monthly_price: '',
        yearly_price: '',

        currency: 'USD',

        trial_days: 0,
        sort_order: 0,

        stripe_product_id: '',
        stripe_price_id_monthly: '',
        stripe_price_id_yearly: '',

        is_active: true,
        is_featured: false,

        feature_access: [],
        tool_access: [],
    });

    const toggle = (collection, slug) => {
        const index = collection.indexOf(slug);

        if (index === -1) {
            collection.push(slug);
        } else {
            collection.splice(index, 1);
        }
    };

    const submit = () => {
        form.post(route('admin.plans.store'));
    };
</script>

<template>

    <Head title="Create Plan" />

    <AdminLayout>

        <template #header>
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-[#FF4040]">
                    Subscription Management
                </p>

                <h1 class="mt-2 text-4xl font-black text-[#131747]">
                    Create Plan
                </h1>

                <p class="mt-2 text-[#131747]/60">
                    Create a new subscription plan and define calculator access.
                </p>
            </div>
        </template>

        <div class="space-y-8">

            <!-- Hero -->

            <div class="relative overflow-hidden rounded-[2rem] bg-[#131747] p-8 text-white shadow-xl">
                <div
                    class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(255,64,64,0.25),_transparent_50%)]" />

                <div class="relative">

                    <span
                        class="inline-flex rounded-full bg-white/10 px-3 py-1 text-[10px] font-bold uppercase tracking-widest">
                        New Subscription Plan
                    </span>

                    <h2 class="mt-4 text-3xl font-black">
                        {{ form.name || 'Plan Name' }}
                    </h2>

                    <p class="mt-2 max-w-2xl text-white/70">
                        {{
                            form.description ||
                            'Create a new pricing plan for your customers.'
                        }}
                    </p>

                </div>
            </div>

            <form @submit.prevent="submit">

                <div class="grid gap-8 lg:grid-cols-3">

                    <!-- Left -->

                    <div class="lg:col-span-2 space-y-8">

                        <!-- Plan Information -->

                        <div class="rounded-[2rem] border border-[#131747]/10 bg-white p-8">
                            <div class="flex items-center gap-3">
                                <Package class="h-5 w-5 text-[#FF4040]" />

                                <h3 class="text-xl font-black text-[#131747]">
                                    Plan Information
                                </h3>
                            </div>

                            <div class="mt-6 grid gap-5 md:grid-cols-2">

                                <input v-model="form.name" type="text" placeholder="Plan Name"
                                    class="rounded-xl border border-[#131747]/10 px-4 py-3" />

                                <input v-model="form.slug" type="text" placeholder="plan-slug"
                                    class="rounded-xl border border-[#131747]/10 px-4 py-3" />

                                <textarea v-model="form.description" rows="4" placeholder="Description"
                                    class="md:col-span-2 rounded-xl border border-[#131747]/10 px-4 py-3" />

                            </div>
                        </div>

                        <!-- Pricing -->

                        <div class="rounded-[2rem] border border-[#131747]/10 bg-white p-8">
                            <div class="flex items-center gap-3">
                                <DollarSign class="h-5 w-5 text-[#FF4040]" />

                                <h3 class="text-xl font-black text-[#131747]">
                                    Pricing
                                </h3>
                            </div>

                            <div class="mt-6 grid gap-5 md:grid-cols-2">

                                <input v-model.number="form.monthly_price" type="number" step="0.01"
                                    placeholder="Monthly Price"
                                    class="rounded-xl border border-[#131747]/10 px-4 py-3" />

                                <input v-model.number="form.yearly_price" type="number" step="0.01"
                                    placeholder="Yearly Price"
                                    class="rounded-xl border border-[#131747]/10 px-4 py-3" />

                            </div>
                        </div>

                        <!-- Stripe -->

                        <div class="rounded-[2rem] border border-[#131747]/10 bg-white p-8">
                            <div class="flex items-center gap-3">
                                <CreditCard class="h-5 w-5 text-[#FF4040]" />

                                <h3 class="text-xl font-black text-[#131747]">
                                    Stripe Configuration
                                </h3>
                            </div>

                            <div class="mt-6 grid gap-5">

                                <input v-model="form.stripe_product_id" type="text" placeholder="Stripe Product ID"
                                    class="rounded-xl border border-[#131747]/10 px-4 py-3" />

                                <input v-model="form.stripe_price_id_monthly" type="text" placeholder="Monthly Price ID"
                                    class="rounded-xl border border-[#131747]/10 px-4 py-3" />

                                <input v-model="form.stripe_price_id_yearly" type="text" placeholder="Yearly Price ID"
                                    class="rounded-xl border border-[#131747]/10 px-4 py-3" />

                            </div>
                        </div>

                        <!-- Tools -->

                        <div class="rounded-[2rem] border border-[#131747]/10 bg-white p-8">
                            <div class="flex items-center gap-3">
                                <Calculator class="h-5 w-5 text-[#FF4040]" />

                                <h3 class="text-xl font-black text-[#131747]">
                                    Calculator Access
                                </h3>
                            </div>

                            <div class="mt-6 grid gap-4 md:grid-cols-2">

                                <button v-for="tool in availableTools" :key="tool.slug" type="button"
                                    @click="toggle(form.tool_access, tool.slug)"
                                    class="rounded-xl border p-4 text-left transition" :class="form.tool_access.includes(tool.slug)
                                            ? 'border-[#131747] bg-[#131747]/5'
                                            : 'border-[#131747]/10'
                                        ">
                                    <p class="font-bold text-[#131747]">
                                        {{ tool.title }}
                                    </p>
                                </button>

                            </div>
                        </div>

                    </div>

                    <!-- Sidebar -->

                    <div class="space-y-6">

                        <div class="rounded-[2rem] border border-[#131747]/10 bg-white p-8">
                            <h3 class="text-lg font-black text-[#131747]">
                                Live Preview
                            </h3>

                            <p class="mt-6 text-2xl font-black text-[#131747]">
                                {{ form.name || 'Plan Name' }}
                            </p>

                            <p class="mt-2 text-sm text-[#131747]/50">
                                {{ form.description }}
                            </p>

                            <div class="mt-6">
                                <span class="text-4xl font-black text-[#131747]">
                                    ${{ form.monthly_price || 0 }}
                                </span>

                                <span class="text-[#131747]/50">
                                    /month
                                </span>
                            </div>
                        </div>

                        <div class="rounded-[2rem] border border-[#131747]/10 bg-white p-8">
                            <h3 class="text-lg font-black text-[#131747]">
                                Settings
                            </h3>

                            <div class="mt-6 space-y-4">

                                <label class="flex items-center gap-3">
                                    <input v-model="form.is_active" type="checkbox" />

                                    <span>
                                        Active Plan
                                    </span>
                                </label>

                                <label class="flex items-center gap-3">
                                    <input v-model="form.is_featured" type="checkbox" />

                                    <span>
                                        Featured Plan
                                    </span>
                                </label>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="mt-8 flex justify-end gap-3">
                    <Link :href="route('admin.plans.index')"
                        class="rounded-xl border border-[#131747]/10 px-6 py-3 font-bold text-[#131747]">
                        Cancel
                    </Link>

                    <PrimaryButton :disabled="form.processing" class="px-8 py-3">
                        Create Plan
                    </PrimaryButton>
                </div>

            </form>

        </div>

    </AdminLayout>
</template>
