<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Pencil, DollarSign, Calculator } from 'lucide-vue-next';

const props = defineProps({
    plan: {
        type: Object,
        required: true,
    },

    availableTools: {
        type: Array,
        default: () => [],
    },
});

const form = useForm({
    ...props.plan,
    tool_access: [...(props.plan.tool_access || [])],
    feature_access: [...(props.plan.feature_access || [])],
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
    form.patch(route('admin.plans.update', props.plan.id));
};
</script>

<template>
    <Head :title="`Edit ${plan.name}`" />

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
                    Edit Plan
                </h1>

                <p
                    class="mt-2 text-[#131747]/60"
                >
                    Update pricing, calculator access, and plan settings.
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

                <div class="relative">
                    <span
                        class="inline-flex rounded-full bg-white/10 px-3 py-1 text-[10px] font-bold uppercase tracking-widest"
                    >
                        {{ form.slug }}
                    </span>

                    <h2
                        class="mt-4 text-3xl font-black"
                    >
                        {{ form.name }}
                    </h2>

                    <p
                        class="mt-3 max-w-2xl text-white/70"
                    >
                        {{ form.description }}
                    </p>
                </div>
            </div>

            <form @submit.prevent="submit">

                <div class="grid gap-8 lg:grid-cols-3">

                    <!-- Main -->
                    <div class="lg:col-span-2 space-y-8">

                        <!-- Plan Information -->
                        <div
                            class="rounded-[2rem] border border-[#131747]/10 bg-white p-8 shadow-sm"
                        >
                            <h3
                                class="text-xl font-black text-[#131747]"
                            >
                                Plan Information
                            </h3>

                            <div
                                class="mt-6 grid gap-5 md:grid-cols-2"
                            >

                                <div>
                                    <label
                                        class="mb-2 block text-sm font-bold text-[#131747]"
                                    >
                                        Plan Name
                                    </label>

                                    <input
                                        v-model="form.name"
                                        type="text"
                                        class="w-full rounded-xl border border-[#131747]/10 px-4 py-3"
                                    />
                                </div>

                                <div>
                                    <label
                                        class="mb-2 block text-sm font-bold text-[#131747]"
                                    >
                                        Slug
                                    </label>

                                    <input
                                        v-model="form.slug"
                                        type="text"
                                        class="w-full rounded-xl border border-[#131747]/10 px-4 py-3 font-mono"
                                    />
                                </div>

                                <div class="md:col-span-2">
                                    <label
                                        class="mb-2 block text-sm font-bold text-[#131747]"
                                    >
                                        Description
                                    </label>

                                    <textarea
                                        v-model="form.description"
                                        rows="4"
                                        class="w-full rounded-xl border border-[#131747]/10 px-4 py-3"
                                    />
                                </div>

                            </div>
                        </div>

                        <!-- Pricing -->
                        <div
                            class="rounded-[2rem] border border-[#131747]/10 bg-white p-8 shadow-sm"
                        >
                            <div
                                class="flex items-center gap-3"
                            >
                                <DollarSign
                                    class="h-5 w-5 text-[#FF4040]"
                                />

                                <h3
                                    class="text-xl font-black text-[#131747]"
                                >
                                    Pricing
                                </h3>
                            </div>

                            <div
                                class="mt-6 grid gap-5 md:grid-cols-2"
                            >

                                <div>
                                    <label
                                        class="mb-2 block text-sm font-bold text-[#131747]"
                                    >
                                        Monthly Price
                                    </label>

                                    <input
                                        v-model.number="form.monthly_price"
                                        type="number"
                                        step="0.01"
                                        class="w-full rounded-xl border border-[#131747]/10 px-4 py-3"
                                    />
                                </div>

                                <div>
                                    <label
                                        class="mb-2 block text-sm font-bold text-[#131747]"
                                    >
                                        Yearly Price
                                    </label>

                                    <input
                                        v-model.number="form.yearly_price"
                                        type="number"
                                        step="0.01"
                                        class="w-full rounded-xl border border-[#131747]/10 px-4 py-3"
                                    />
                                </div>

                            </div>
                        </div>

                        <!-- Calculator Access -->
                        <div
                            class="rounded-[2rem] border border-[#131747]/10 bg-white p-8 shadow-sm"
                        >
                            <div
                                class="flex items-center gap-3"
                            >
                                <Calculator
                                    class="h-5 w-5 text-[#FF4040]"
                                />

                                <h3
                                    class="text-xl font-black text-[#131747]"
                                >
                                    Calculator Access
                                </h3>
                            </div>

                            <div
                                class="mt-6 grid gap-4 md:grid-cols-2"
                            >

                                <button
                                    v-for="tool in availableTools"
                                    :key="tool.slug"
                                    type="button"
                                    @click="toggle(form.tool_access, tool.slug)"
                                    class="rounded-xl border p-4 text-left transition"
                                    :class="
                                        form.tool_access.includes(tool.slug)
                                            ? 'border-[#131747] bg-[#131747]/5'
                                            : 'border-[#131747]/10'
                                    "
                                >
                                    <p
                                        class="font-bold text-[#131747]"
                                    >
                                        {{ tool.title }}
                                    </p>

                                    <p
                                        class="mt-1 text-xs text-[#131747]/50"
                                    >
                                        Calculator Access
                                    </p>
                                </button>

                            </div>
                        </div>

                    </div>

                    <!-- Sidebar -->
                    <div class="space-y-6">

                        <!-- Preview -->
                        <div
                            class="rounded-[2rem] border border-[#131747]/10 bg-white p-8 shadow-sm"
                        >
                            <h3
                                class="text-lg font-black text-[#131747]"
                            >
                                Plan Preview
                            </h3>

                            <div
                                class="mt-6"
                            >
                                <p
                                    class="text-2xl font-black text-[#131747]"
                                >
                                    {{ form.name }}
                                </p>

                                <p
                                    class="mt-2 text-sm text-[#131747]/50"
                                >
                                    {{ form.description }}
                                </p>

                                <div
                                    class="mt-6"
                                >
                                    <span
                                        class="text-4xl font-black text-[#131747]"
                                    >
                                        ${{ form.monthly_price || 0 }}
                                    </span>

                                    <span
                                        class="text-[#131747]/50"
                                    >
                                        /month
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Settings -->
                        <div
                            class="rounded-[2rem] border border-[#131747]/10 bg-white p-8 shadow-sm"
                        >
                            <h3
                                class="text-lg font-black text-[#131747]"
                            >
                                Plan Settings
                            </h3>

                            <div
                                class="mt-6 space-y-4"
                            >

                                <label
                                    class="flex items-center gap-3"
                                >
                                    <input
                                        v-model="form.is_active"
                                        type="checkbox"
                                        class="rounded"
                                    />

                                    <span
                                        class="font-semibold text-[#131747]"
                                    >
                                        Active Plan
                                    </span>
                                </label>

                                <label
                                    class="flex items-center gap-3"
                                >
                                    <input
                                        v-model="form.is_featured"
                                        type="checkbox"
                                        class="rounded"
                                    />

                                    <span
                                        class="font-semibold text-[#131747]"
                                    >
                                        Featured Plan
                                    </span>
                                </label>

                            </div>
                        </div>

                    </div>

                </div>

                <!-- Actions -->
                <div
                    class="mt-8 flex justify-end gap-3"
                >
                    <Link
                        :href="route('admin.plans.show', plan.id)"
                        class="rounded-xl border border-[#131747]/10 px-6 py-3 font-bold text-[#131747]"
                    >
                        View Plan
                    </Link>

                    <PrimaryButton
                        :disabled="form.processing"
                        class="px-8 py-3"
                    >
                        Save Changes
                    </PrimaryButton>
                </div>

            </form>

        </div>

    </AdminLayout>
</template>