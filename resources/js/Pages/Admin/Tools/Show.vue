<script setup>
    import AdminLayout from '@/Layouts/AdminLayout.vue';
    import { Head, Link } from '@inertiajs/vue3';

    defineProps({
        tool: { type: Object, required: true },
        plans: { type: Array, default: () => [] },
    });
</script>

<template>

    <Head :title="`Tool - ${tool.title}`" />

    <AdminLayout>
        <template #header>
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-[#FF4040]">
                    Calculator Management
                </p>

                <h1 class="mt-2 text-4xl font-black text-[#131747]">
                    {{ tool.title }}
                </h1>

                <p class="mt-2 text-[#131747]/60">
                    Review calculator settings, visibility, access permissions,
                    and plan assignments.
                </p>
            </div>
        </template>

        <div class="space-y-8">

            <!-- Hero Card -->
            <div class="
        relative
        overflow-hidden
        rounded-[2rem]
        bg-[#131747]
        p-8
        text-white
        shadow-xl
    ">
                <div
                    class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(255,64,64,0.25),_transparent_50%)]" />

                <div class="
            relative
            flex
            flex-col
            gap-6
            lg:flex-row
            lg:items-center
            lg:justify-between
        ">
                    <div>

                        <div class="
                    inline-flex
                    rounded-full
                    bg-white/10
                    px-4
                    py-2
                    text-[10px]
                    font-bold
                    uppercase
                    tracking-widest
                ">
                            {{ tool.slug }}
                        </div>

                        <h2 class="mt-5 text-3xl font-black">
                            {{ tool.title }}
                        </h2>

                        <p class="
                    mt-3
                    max-w-3xl
                    text-white/75
                ">
                            {{ tool.description || 'No description available.' }}
                        </p>

                    </div>

                    <Link :href="route('admin.tools.edit', tool.id)" class="
                rounded-xl
                bg-[#FF4040]
                px-6
                py-3
                text-sm
                font-bold
                text-white
                transition
                hover:bg-white
                hover:text-[#131747]
            ">
                        Edit Tool
                    </Link>

                </div>
            </div>

            <!-- Overview Cards -->

            <div class="
        grid
        gap-5
        md:grid-cols-2
        xl:grid-cols-4
    ">

                <div class="rounded-[1.5rem] border border-[#131747]/10 bg-white p-6 shadow-sm">
                    <p class="text-[10px] font-bold uppercase tracking-widest text-[#131747]/40">
                        Route
                    </p>

                    <h3 class="mt-3 font-mono text-sm font-bold text-[#131747]">
                        {{ tool.route || 'N/A' }}
                    </h3>
                </div>

                <div class="rounded-[1.5rem] border border-[#131747]/10 bg-white p-6 shadow-sm">
                    <p class="text-[10px] font-bold uppercase tracking-widest text-[#131747]/40">
                        Icon
                    </p>

                    <h3 class="mt-3 text-xl font-black text-[#131747]">
                        {{ tool.icon }}
                    </h3>
                </div>

                <div class="rounded-[1.5rem] border border-[#131747]/10 bg-white p-6 shadow-sm">
                    <p class="text-[10px] font-bold uppercase tracking-widest text-[#131747]/40">
                        Display Order
                    </p>

                    <h3 class="mt-3 text-xl font-black text-[#131747]">
                        {{ tool.display_order }}
                    </h3>
                </div>

                <div class="rounded-[1.5rem] border border-[#131747]/10 bg-white p-6 shadow-sm">
                    <p class="text-[10px] font-bold uppercase tracking-widest text-[#131747]/40">
                        Status
                    </p>

                    <span class="
                mt-3
                inline-flex
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
                </div>

            </div>

            <!-- Visibility Settings -->

            <div class="
        rounded-[2rem]
        border
        border-[#131747]/10
        bg-white
        p-8
        shadow-sm
    ">
                <h3 class="
            text-xl
            font-black
            text-[#131747]
        ">
                    Visibility & Access
                </h3>

                <div class="
            mt-6
            grid
            gap-4
            md:grid-cols-2
            xl:grid-cols-4
        ">

                    <div class="rounded-xl bg-[#131747]/5 p-4">
                        Featured:
                        <strong>{{ tool.is_featured ? 'Yes' : 'No' }}</strong>
                    </div>

                    <div class="rounded-xl bg-[#131747]/5 p-4">
                        Recommended:
                        <strong>{{ tool.is_recommended ? 'Yes' : 'No' }}</strong>
                    </div>

                    <div class="rounded-xl bg-[#131747]/5 p-4">
                        Homepage:
                        <strong>{{ tool.show_on_homepage ? 'Yes' : 'No' }}</strong>
                    </div>

                    <div class="rounded-xl bg-[#131747]/5 p-4">
                        Dashboard:
                        <strong>{{ tool.show_on_dashboard ? 'Yes' : 'No' }}</strong>
                    </div>

                    <div class="rounded-xl bg-[#131747]/5 p-4">
                        Subscription:
                        <strong>{{ tool.requires_subscription ? 'Required' : 'Free' }}</strong>
                    </div>

                    <div class="rounded-xl bg-[#131747]/5 p-4">
                        Coming Soon:
                        <strong>{{ tool.is_coming_soon ? 'Yes' : 'No' }}</strong>
                    </div>

                </div>
            </div>

            <!-- Plans -->

            <div class="
        rounded-[2rem]
        border
        border-[#131747]/10
        bg-white
        p-8
        shadow-sm
    ">
                <div class="flex items-center justify-between">

                    <div>
                        <h3 class="
                    text-xl
                    font-black
                    text-[#131747]
                ">
                            Included Plans
                        </h3>

                        <p class="
                    mt-1
                    text-sm
                    text-[#131747]/50
                ">
                            Subscription plans that provide access to this calculator.
                        </p>
                    </div>

                    <span class="
                rounded-xl
                bg-[#131747]
                px-4
                py-2
                text-sm
                font-bold
                text-white
            ">
                        {{ plans.length }} Plans
                    </span>

                </div>

                <div v-if="plans.length" class="
            mt-6
            grid
            gap-4
            md:grid-cols-2
            xl:grid-cols-3
        ">

                    <div v-for="plan in plans" :key="plan.id" class="
                rounded-xl
                border
                border-[#131747]/10
                p-5
            ">
                        <h4 class="
                    font-bold
                    text-[#131747]
                ">
                            {{ plan.name }}
                        </h4>

                        <p class="
                    mt-2
                    text-sm
                    text-[#131747]/50
                ">
                            {{ plan.description }}
                        </p>
                    </div>

                </div>

                <div v-else class="
            mt-6
            rounded-xl
            border
            border-dashed
            border-[#131747]/15
            p-12
            text-center
        ">
                    <p class="
                font-bold
                text-[#131747]/50
            ">
                        No plans currently include this tool.
                    </p>
                </div>
            </div>
        </div>

    </AdminLayout>
</template>
