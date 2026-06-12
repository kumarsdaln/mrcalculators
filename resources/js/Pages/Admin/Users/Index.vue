<script setup>
    import { Head, Link, router } from '@inertiajs/vue3';
    import { reactive } from 'vue';
    import AdminLayout from '@/Layouts/AdminLayout.vue';
    import AppTableLayout from '@/Components/Table/AppTableLayout.vue';
    import AppTableFilters from '@/Components/Table/AppTableFilters.vue';
    import AppTable from '@/Components/Table/AppTable.vue';
    import AppTableHead from '@/Components/Table/AppTableHead.vue';
    import AppTableBody from '@/Components/Table/AppTableBody.vue';
    import AppTableRow from '@/Components/Table/AppTableRow.vue';
    import AppTableData from '@/Components/Table/AppTableData.vue';
    import AvatarCell from '@/Components/AvatarCell.vue';
import ActionButtons from '@/Components/ActionButtons.vue';

    const props = defineProps({
        users: {
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

    const userRoles = reactive(
        Object.fromEntries(props.users.map((user) => [user.id, user.role])),
    );

    const saveUser = (userId) => {
        router.patch(
            route('admin.users.update', userId),
            {
                role: userRoles[userId],
            },
            {
                preserveScroll: true,
            },
        );
    };

    const filterForm = reactive({
        search: props.filters.search || '',
        role: props.filters.role || '',
        status: props.filters.status || '',
        plan: props.filters.plan || '',
    });

    const applyFilters = () => {
        router.get(route('admin.users.index'), filterForm, {
            preserveState: true,
            preserveScroll: true,
        });
    };

    const clearFilters = () => {
        filterForm.search = '';
        filterForm.role = '';
        filterForm.status = '';
        filterForm.plan = '';
        applyFilters();
    };

    const columns = [
        { key: 'user', label: 'User' },
        { key: 'role', label: 'Role' },
        { key: 'company', label: 'Company' },
        { key: 'subscription', label: 'Subscription' },
        { key: 'created', label: 'Joined' },
        { key: 'actions', label: '' },
    ];
</script>

<template>

    <Head title="Admin Users" />

    <AdminLayout>
        <template #header>
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-[#FF4040]">
                        User Management
                    </p>

                    <h1 class="mt-2 text-4xl font-black text-[#131747]">
                        Users
                    </h1>

                    <p class="mt-2 text-[#131747]/60">
                        Manage user accounts, subscriptions, and access permissions.
                    </p>
                </div>

                <Link :href="route('admin.users.create')"
                    class="rounded-xl bg-[#131747] px-5 py-3 text-sm font-bold text-white transition hover:bg-[#FF4040]">
                    Add User
                </Link>

            </div>
        </template>

        <div class="py-10">
            <div class="space-y-8">

                <!-- <AdminNav active="Users" /> -->

                <div class="grid gap-4 md:grid-cols-4">

                    <div class="rounded-[1.5rem] bg-white p-6 border border-[#131747]/10">
                        <p class="text-xs uppercase tracking-widest text-[#131747]/50">
                            Total Users
                        </p>
                        <h3 class="mt-3 text-3xl font-black text-[#131747]">
                            {{ pagination.total }}
                        </h3>
                    </div>

                    <div class="rounded-[1.5rem] bg-white p-6 border border-[#131747]/10">
                        <p class="text-xs uppercase tracking-widest text-[#131747]/50">
                            Active Subscribers
                        </p>
                        <h3 class="mt-3 text-3xl font-black text-[#131747]">
                            {{
                                users.filter(u => u.subscription?.status === 'active').length
                            }}
                        </h3>
                    </div>

                    <div class="rounded-[1.5rem] bg-white p-6 border border-[#131747]/10">
                        <p class="text-xs uppercase tracking-widest text-[#131747]/50">
                            Admins
                        </p>
                        <h3 class="mt-3 text-3xl font-black text-[#131747]">
                            {{
                                users.filter(u => u.role === 'admin').length
                            }}
                        </h3>
                    </div>

                    <div class="rounded-[1.5rem] bg-red-50 p-6 border border-red-100">
                        <p class="text-xs uppercase tracking-widest text-red-500">
                            Past Due
                        </p>
                        <h3 class="mt-3 text-3xl font-black text-red-600">
                            {{
                                users.filter(u => u.subscription?.status === 'past_due').length
                            }}
                        </h3>
                    </div>

                </div>
                <!-- USERS TAB -->
                <div class="space-y-8 animate-fade-in">
                    <AppTableLayout title="User Roles & Profiles" subtitle="Identity Access Management"
                        :total="pagination.total" :current-page="pagination.current_page"
                        :last-page="pagination.last_page">

                        <!-- Filters -->

                        <template #filters>

                            <AppTableFilters>

                                <form class="grid gap-4 xl:grid-cols-[1fr,220px,220px,auto,auto]"
                                    @submit.prevent="applyFilters">

                                    <input v-model="filterForm.search" type="search" placeholder="Search users..."
                                        class="
                        rounded-xl
                        border
                        border-[#131747]/10
                        px-4
                        py-3
                    ">

                                    <select v-model="filterForm.role" class="
                        rounded-xl
                        border
                        border-[#131747]/10
                        px-4
                        py-3
                    ">
                                        <option value="">
                                            All Roles
                                        </option>

                                        <option value="admin">
                                            Admin
                                        </option>

                                        <option value="user">
                                            User
                                        </option>
                                    </select>

                                    <select v-model="filterForm.subscription" class="
                        rounded-xl
                        border
                        border-[#131747]/10
                        px-4
                        py-3
                    ">
                                        <option value="">
                                            All Plans
                                        </option>

                                        <option v-for="plan in plans" :key="plan.id" :value="plan.slug">
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

                                <AppTableRow v-for="user in users" :key="user.id">

                                    <!-- User -->

                                    <AppTableData>

                                        <AvatarCell :name="user.name" :email="user.email" />

                                    </AppTableData>

                                    <!-- Role -->

                                    <AppTableData>

                                        <span class="
                            inline-flex
                            rounded-lg
                            px-3
                            py-1.5
                            text-xs
                            font-bold
                        " :class="user.role === 'admin'
                            ? 'bg-[#131747] text-white'
                            : 'bg-[#131747]/5 text-[#131747]'
                            ">
                                            {{ user.role }}
                                        </span>

                                    </AppTableData>

                                    <!-- Company -->

                                    <AppTableData>

                                        <div>

                                            <p class="
                                font-medium
                                text-[#131747]
                            ">
                                                {{ user.company_name || '—' }}
                                            </p>

                                            <p class="
                                text-xs
                                text-[#131747]/50
                            ">
                                                {{ user.phone || 'No phone' }}
                                            </p>

                                        </div>

                                    </AppTableData>

                                    <!-- Subscription -->

                                    <AppTableData>

                                        <span class="
                            inline-flex
                            rounded-lg
                            bg-green-50
                            px-3
                            py-1.5
                            text-xs
                            font-bold
                            text-green-700
                        ">
                                            {{
                                                user.subscription?.plan_name
                                                || 'No Plan'
                                            }}
                                        </span>

                                    </AppTableData>

                                    <!-- Joined -->

                                    <AppTableData>

                                        <div>

                                            <p class="
                                text-sm
                                font-medium
                                text-[#131747]
                            ">
                                                {{
                                                    new Date(
                                                        user.created_at
                                                    ).toLocaleDateString()
                                                }}
                                            </p>

                                            <p class="
                                text-xs
                                text-[#131747]/50
                            ">
                                                ID #{{ user.id }}
                                            </p>

                                        </div>

                                    </AppTableData>

                                    <!-- Actions -->

                                    <AppTableData>

                                        <ActionButtons :view-url="route(
                                            'admin.users.show',
                                            user.id
                                        )
                                            " :edit-url="route(
                                                'admin.users.edit',
                                                user.id
                                            )
                                                " />

                                    </AppTableData>

                                </AppTableRow>

                                <!-- Empty State -->

                                <AppTableRow v-if="!users.length">
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
                                                No Users Found
                                            </h3>

                                            <p class="
                                mt-2
                                text-[#131747]/50
                            ">
                                                No user records match
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
                                    {{ users.length }}
                                    of
                                    {{ pagination.total }}
                                    users
                                </p>

                                <Pagination :links="pagination.links" />

                            </div>

                        </template>

                    </AppTableLayout>
                </div>

            </div>
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
