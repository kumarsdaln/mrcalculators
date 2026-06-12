<script setup>
    import AdminLayout from '@/Layouts/AdminLayout.vue';
    import { Head, Link } from '@inertiajs/vue3';
    import AppTableRow from '@/Components/Table/AppTableRow.vue';
    import AppTableData from '@/Components/Table/AppTableData.vue';
    import ActionButtons from '@/Components/ActionButtons.vue';
    import AppTableLayout from '@/Components/Table/AppTableLayout.vue';
    import AppTable from '@/Components/Table/AppTable.vue';
    import AppTableHead from '@/Components/Table/AppTableHead.vue';
    import AppTableBody from '@/Components/Table/AppTableBody.vue';

    const props = defineProps({
        tools: {
            type: Array,
            required: true,
        },
    });

    const columns = [
        { key: 'tool', label: 'Tool' },
        { key: 'category', label: 'Category' },
        { key: 'status', label: 'Status' },
        { key: 'visibility', label: 'Visibility' },
        { key: 'plans', label: 'Plans' },
        { key: 'order', label: 'Order' },
        { key: 'actions', label: '' },
    ]
</script>

<template>

    <Head title="Admin Tools" />

    <AdminLayout>
        <template #header>
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-[#FF4040]">
                        Operations workspace
                    </p>
                    <h2 class="mt-2 text-2xl font-bold leading-tight text-[#131747]">
                        Admin Command Center
                    </h2>
                </div>
                <Link :href="route('admin.tools.create')" class="
                    inline-flex
                    items-center
                    justify-center
                    rounded-xl
                    bg-[#131747]
                    px-5
                    py-3
                    text-sm
                    font-bold
                    text-white
                    transition
                    hover:bg-[#FF4040]
                ">
                    Create Tool
                </Link>
            </div>

        </template>

        <div class="py-10">

            <AppTableLayout title="Calculator Tools" subtitle="Tool Library Management" :total="tools.length">

                <AppTable>

                    <AppTableHead :columns="[
                        { key: 'tool', label: 'Tool' },
                        { key: 'category', label: 'Category' },
                        { key: 'status', label: 'Status' },
                        { key: 'visibility', label: 'Visibility' },
                        { key: 'plans', label: 'Plans' },
                        { key: 'order', label: 'Order' },
                        { key: 'actions', label: '' }
                    ]" />

                    <AppTableBody>

                        <AppTableRow v-for="tool in tools" :key="tool.id">

                            <!-- Tool -->

                            <AppTableData>

                                <div class="
                            flex
                            items-center
                            gap-4
                        ">

                                    <div class="
                                flex
                                h-11
                                w-11
                                items-center
                                justify-center
                                rounded-2xl
                                bg-[#131747]/5
                                font-black
                                text-[#131747]
                            ">
                                        {{ tool.title.charAt(0) }}
                                    </div>

                                    <div>

                                        <p class="
                                    font-bold
                                    text-[#131747]
                                ">
                                            {{ tool.title }}
                                        </p>

                                        <p class="
                                    text-xs
                                    text-[#131747]/50
                                ">
                                            {{ tool.slug }}
                                        </p>

                                    </div>

                                </div>

                            </AppTableData>

                            <!-- Category -->

                            <AppTableData>

                                <span class="
                            rounded-lg
                            bg-[#131747]/5
                            px-3
                            py-1.5
                            text-xs
                            font-bold
                            text-[#131747]
                        ">
                                    {{ tool.category || 'General' }}
                                </span>

                            </AppTableData>

                            <!-- Status -->

                            <AppTableData>

                                <span class="
                            rounded-full
                            px-3
                            py-1
                            text-xs
                            font-bold
                        " :class="tool.is_active
                            ? 'bg-green-100 text-green-700'
                            : 'bg-red-100 text-red-700'
                            ">
                                    {{ tool.is_active ? 'Active' : 'Inactive' }}
                                </span>

                            </AppTableData>

                            <!-- Visibility -->

                            <AppTableData>

                                <div class="
                            flex
                            flex-wrap
                            gap-2
                        ">

                                    <span v-if="tool.is_featured" class="
                                rounded-full
                                bg-blue-100
                                px-2
                                py-1
                                text-[10px]
                                font-bold
                                text-blue-700
                            ">
                                        Featured
                                    </span>

                                    <span v-if="tool.show_on_homepage" class="
                                rounded-full
                                bg-purple-100
                                px-2
                                py-1
                                text-[10px]
                                font-bold
                                text-purple-700
                            ">
                                        Homepage
                                    </span>

                                    <span v-if="tool.show_on_dashboard" class="
                                rounded-full
                                bg-orange-100
                                px-2
                                py-1
                                text-[10px]
                                font-bold
                                text-orange-700
                            ">
                                        Dashboard
                                    </span>

                                </div>

                            </AppTableData>

                            <!-- Plans -->

                            <AppTableData>

                                <span class="
                            rounded-lg
                            bg-[#131747]
                            px-3
                            py-1.5
                            text-xs
                            font-bold
                            text-white
                        ">
                                    {{ tool.plans_count ?? 0 }}
                                </span>

                            </AppTableData>

                            <!-- Order -->

                            <AppTableData>

                                <span class="
                            font-mono
                            font-bold
                            text-[#131747]
                        ">
                                    {{ tool.display_order }}
                                </span>

                            </AppTableData>

                            <!-- Actions -->

                            <AppTableData>

                                <ActionButtons :view-url="route('admin.tools.show', tool.id)"
                                    :edit-url="route('admin.tools.edit', tool.id)" />

                            </AppTableData>

                        </AppTableRow>

                        <AppTableRow v-if="!tools.length">

                            <AppTableData :colspan="7">

                                <div class="
                            py-20
                            text-center
                        ">

                                    <h3 class="
                                text-xl
                                font-black
                                text-[#131747]
                            ">
                                        No Tools Found
                                    </h3>

                                    <p class="
                                mt-2
                                text-[#131747]/50
                            ">
                                        Create your first calculator tool.
                                    </p>

                                    <Link :href="route('admin.tools.create')" class="
                                mt-6
                                inline-flex
                                rounded-xl
                                bg-[#131747]
                                px-5
                                py-3
                                text-sm
                                font-bold
                                text-white
                            ">
                                        Create Tool
                                    </Link>

                                </div>

                            </AppTableData>

                        </AppTableRow>

                    </AppTableBody>

                </AppTable>

            </AppTableLayout>
        </div>
    </AdminLayout>
</template>
