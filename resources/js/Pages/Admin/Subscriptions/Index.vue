<script setup>
    import AppTable from '@/Components/Table/AppTable.vue';
    import AppTableBody from '@/Components/Table/AppTableBody.vue';
    import AppTableData from '@/Components/Table/AppTableData.vue';
    import AppTableHead from '@/Components/Table/AppTableHead.vue';
    import AppTableLayout from '@/Components/Table/AppTableLayout.vue';
    import AppTableRow from '@/Components/Table/AppTableRow.vue';
    import AppTableFilters from '@/Components/Table/AppTableFilters.vue';
    import AvatarCell from '@/Components/AvatarCell.vue';
    import Pagination from '@/Components/Pagination.vue';
    import StatusBadge from '@/Components/StatusBadge.vue';
    import ActionButtons from '@/Components/ActionButtons.vue';
    import AdminLayout from '@/Layouts/AdminLayout.vue';
    import { Head, Link, router } from '@inertiajs/vue3';
    import { reactive } from 'vue';
import { Link2 } from 'lucide-vue-next';

    const props = defineProps({
        subscriptions: {
            type: Array,
            required: true,
        },
        pagination: {
            type: Object,
            required: true,
        },
        filters: {
            type: Object,
            default: () => ({}),
        },
        plans: {
            type: Array,
            default: () => [],
        },
        statuses: {
            type: Array,
            default: () => [],
        },
    });

    const filterForm = reactive({
        search: props.filters.search || '',
        status: props.filters.status || '',
        plan: props.filters.plan || '',
    });

    const applyFilters = () => {
        router.get(route('admin.subscriptions'), filterForm, {
            preserveState: true,
            preserveScroll: true,
        });
    };

    const clearFilters = () => {
        filterForm.search = '';
        filterForm.status = '';
        filterForm.plan = '';
        applyFilters();
    };
</script>

<template>

    <Head title="Admin Subscriptions" />

    <AdminLayout>
        <template #header>
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-[#FF4040]">
                        Revenue Management
                    </p>

                    <h1 class="mt-2 text-4xl font-black text-[#131747]">
                        Subscriptions
                    </h1>

                    <p class="mt-2 text-[#131747]/60">
                        Monitor subscriptions, billing activity, and customer plans.
                    </p>
                </div>

            </div>
        </template>

        <div class="py-10">
            <div class="space-y-8 mb-6">
                <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">

                    <!-- Total -->

                    <div class="rounded-[1.75rem] border border-[#131747]/10 bg-white p-6 shadow-sm">
                        <p class="text-sm text-[#131747]/50">
                            Total Subscriptions
                        </p>

                        <h3 class="mt-3 text-4xl font-black text-[#131747]">
                            {{ pagination.total }}
                        </h3>
                    </div>

                    <!-- Active -->

                    <div class="rounded-[1.75rem] border border-green-100 bg-white p-6 shadow-sm">
                        <p class="text-sm text-[#131747]/50">
                            Active
                        </p>

                        <h3 class="mt-3 text-4xl font-black text-green-600">
                            {{
                                subscriptions.filter(
                                    s => s.status === 'active'
                                ).length
                            }}
                        </h3>
                    </div>

                    <!-- Trial -->

                    <div class="rounded-[1.75rem] border border-blue-100 bg-white p-6 shadow-sm">
                        <p class="text-sm text-[#131747]/50">
                            Trialing
                        </p>

                        <h3 class="mt-3 text-4xl font-black text-blue-600">
                            {{
                                subscriptions.filter(
                                    s => s.status === 'trialing'
                                ).length
                            }}
                        </h3>
                    </div>

                    <!-- Past Due -->

                    <div class="rounded-[1.75rem] border border-red-100 bg-white p-6 shadow-sm">
                        <p class="text-sm text-[#131747]/50">
                            Past Due
                        </p>

                        <h3 class="mt-3 text-4xl font-black text-red-500">
                            {{
                                subscriptions.filter(
                                    s => s.status === 'past_due'
                                ).length
                            }}
                        </h3>
                    </div>

                </div>
            </div>

            <AppTableLayout title="Subscriptions" subtitle="Revenue Management" :total="pagination.total"
                :current-page="pagination.current_page" :last-page="pagination.last_page">

                <!-- Filters -->
                <template #filters>

                    <AppTableFilters>

                        <form class="grid gap-4 xl:grid-cols-[1fr,220px,220px,auto,auto]"
                            @submit.prevent="applyFilters">

                            <input v-model="filterForm.search" type="search" placeholder="Search customer..." class="
                                rounded-xl
                                border
                                border-[#131747]/10
                                px-4
                                py-3
                                text-sm
                            ">

                            <select v-model="filterForm.status" class="
                                rounded-xl
                                border
                                border-[#131747]/10
                                px-4
                                py-3
                            ">
                                <option value="">
                                    All Statuses
                                </option>

                                <option v-for="status in statuses" :key="status" :value="status">
                                    {{ status }}
                                </option>
                            </select>

                            <select v-model="filterForm.plan" class="
                                rounded-xl
                                border
                                border-[#131747]/10
                                px-4
                                py-3
                            ">
                                <option value="">
                                    All Plans
                                </option>

                                <option v-for="plan in plans" :key="plan.slug" :value="plan.slug">
                                    {{ plan.name }}
                                </option>
                            </select>

                            <button type="submit" class="
                                rounded-xl
                                bg-[#131747]
                                px-6
                                py-3
                                text-sm
                                font-bold
                                text-white
                            ">
                                Search
                            </button>

                            <button type="button" @click="clearFilters" class="
                                rounded-xl
                                border
                                border-[#131747]/10
                                px-6
                                py-3
                                text-sm
                                font-bold
                                text-[#131747]
                            ">
                                Clear
                            </button>

                        </form>

                    </AppTableFilters>

                </template>

                <!-- Table -->

                <AppTable>

                    <AppTableHead :columns="columns" />

                    <AppTableBody>

                        <AppTableRow v-for="subscription in subscriptions" :key="subscription.id">

                            <!-- Customer -->

                            <AppTableData>

                                <AvatarCell :name="subscription.user.name" :email="subscription.user.email" />

                            </AppTableData>

                            <!-- Plan -->

                            <AppTableData>

                                <span class="
                                    inline-flex
                                    rounded-lg
                                    bg-[#131747]
                                    px-3
                                    py-1.5
                                    text-xs
                                    font-bold
                                    text-white
                                ">
                                    {{ subscription.plan || 'Unknown' }}
                                </span>

                            </AppTableData>

                            <!-- Status -->

                            <AppTableData>

                                <StatusBadge :status="subscription.status" />

                            </AppTableData>

                            <!-- Billing -->

                            <AppTableData>

                                <span class="
                                    rounded-lg
                                    bg-[#131747]/5
                                    px-3
                                    py-1.5
                                    text-xs
                                    font-semibold
                                    capitalize
                                    text-[#131747]
                                ">
                                    {{ subscription.interval || 'N/A' }}
                                </span>

                            </AppTableData>

                            <!-- Created -->

                            <AppTableData>

                                <div>

                                    <p class="
                                text-sm
                                font-medium
                                text-[#131747]
                            ">
                                        {{
                                            new Date(
                                                subscription.created_at
                                            ).toLocaleDateString()
                                        }}
                                    </p>

                                    <p class="
                                text-xs
                                text-[#131747]/50
                            ">
                                        Subscription #{{ subscription.id }}
                                    </p>

                                </div>

                            </AppTableData>

                            <!-- Actions -->

                            <AppTableData>

                                <Link class="
                                    h-8
                                    w-8
                                    rounded-lg
                                    bg-[#131747]/10
                                    p-1.5
                                    text-[#131747]
                                    transition
                                    hover:bg-[#131747]/20
                                " :href="route('admin.subscriptions.show', subscription.id)">
                                    View
                                </Link>

                            </AppTableData>

                        </AppTableRow>

                        <!-- Empty State -->

                        <AppTableRow v-if="!subscriptions.length">

                            <AppTableData colspan="6">

                                <div class="
                            py-20
                            text-center
                        ">
                                    <h3 class="
                                text-xl
                                font-black
                                text-[#131747]
                            ">
                                        No Subscriptions Found
                                    </h3>

                                    <p class="
                                mt-2
                                text-[#131747]/50
                            ">
                                        No subscription records match
                                        your filters.
                                    </p>
                                </div>

                            </AppTableData>

                        </AppTableRow>

                    </AppTableBody>

                </AppTable>

                <!-- Pagination -->

                <template #pagination>

                    <div class="
                flex
                items-center
                justify-between
                px-6
                py-4
            ">
                        <p class="
                    text-sm
                    text-[#131747]/50
                ">
                            Showing
                            {{ subscriptions.length }}
                            of
                            {{ pagination.total }}
                            subscriptions
                        </p>

                        <Pagination :links="pagination.links" />
                    </div>

                </template>

            </AppTableLayout>
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