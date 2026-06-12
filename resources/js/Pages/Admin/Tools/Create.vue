<script setup>
    import AdminLayout from '@/Layouts/AdminLayout.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import { Head, Link, useForm } from '@inertiajs/vue3';

    const form = useForm({
        title: '',
        slug: '',
        subtitle: '',
        description: '',
        short_description: '',
        icon: 'Calculator',
        route: '',
        category: '',
        tag: '',
        badge: '',
        is_active: true,
        is_featured: true,
        is_recommended: false,
        is_coming_soon: false,
        requires_subscription: true,
        display_order: 0,
        show_on_dashboard: true,
        show_on_homepage: true,
        content_json: '{}',
    });

    const submit = () => form.post(route('admin.tools.store'));
</script>

<template>

    <Head title="Create Tool" />
    <AdminLayout>

        <template #header>
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-[#FF4040]">
                    Calculator Management
                </p>

                <h1 class="mt-2 text-4xl font-black text-[#131747]">
                    Create Tool
                </h1>

                <p class="mt-2 text-[#131747]/60">
                    Add a new calculator, configure visibility, access permissions,
                    and content settings.
                </p>
            </div>
        </template>

        <form class="space-y-8" @submit.prevent="submit">

            <!-- Tool Information -->

            <div class="rounded-[2rem] border border-[#131747]/10 bg-white p-8 shadow-sm">
                <h3 class="text-xl font-black text-[#131747]">
                    Tool Information
                </h3>

                <div class="mt-6 grid gap-5 md:grid-cols-2">

                    <div>
                        <label class="mb-2 block text-sm font-bold text-[#131747]">
                            Tool Title
                        </label>

                        <input v-model="form.title" type="text"
                            class="w-full rounded-xl border border-[#131747]/10 px-4 py-3">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-bold text-[#131747]">
                            Slug
                        </label>

                        <input v-model="form.slug" type="text"
                            class="w-full rounded-xl border border-[#131747]/10 px-4 py-3">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-bold text-[#131747]">
                            Subtitle
                        </label>

                        <input v-model="form.subtitle" type="text"
                            class="w-full rounded-xl border border-[#131747]/10 px-4 py-3">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-bold text-[#131747]">
                            Category
                        </label>

                        <input v-model="form.category" type="text"
                            class="w-full rounded-xl border border-[#131747]/10 px-4 py-3">
                    </div>

                </div>
            </div>

            <!-- Display Settings -->

            <div class="rounded-[2rem] border border-[#131747]/10 bg-white p-8 shadow-sm">
                <h3 class="text-xl font-black text-[#131747]">
                    Display Settings
                </h3>

                <div class="mt-6 grid gap-5 md:grid-cols-2">

                    <input v-model="form.icon" placeholder="Lucide Icon"
                        class="rounded-xl border border-[#131747]/10 px-4 py-3">

                    <input v-model="form.route" placeholder="Route Name"
                        class="rounded-xl border border-[#131747]/10 px-4 py-3">

                    <input v-model="form.tag" placeholder="Tag" class="rounded-xl border border-[#131747]/10 px-4 py-3">

                    <input v-model="form.badge" placeholder="Badge"
                        class="rounded-xl border border-[#131747]/10 px-4 py-3">

                    <input v-model.number="form.display_order" type="number" placeholder="Display Order"
                        class="rounded-xl border border-[#131747]/10 px-4 py-3">

                </div>
            </div>

            <!-- Descriptions -->

            <div class="rounded-[2rem] border border-[#131747]/10 bg-white p-8 shadow-sm">
                <h3 class="text-xl font-black text-[#131747]">
                    Descriptions
                </h3>

                <div class="mt-6 space-y-5">

                    <textarea v-model="form.short_description" rows="3" placeholder="Short Description"
                        class="w-full rounded-xl border border-[#131747]/10 px-4 py-3" />

                    <textarea v-model="form.description" rows="6" placeholder="Full Description"
                        class="w-full rounded-xl border border-[#131747]/10 px-4 py-3" />

                </div>
            </div>

            <!-- Visibility & Access -->

            <div class="rounded-[2rem] border border-[#131747]/10 bg-white p-8 shadow-sm">
                <h3 class="text-xl font-black text-[#131747]">
                    Visibility & Access
                </h3>

                <div class="mt-6 grid gap-4 md:grid-cols-3">

                    <label class="flex items-center gap-3">
                        <input v-model="form.is_active" type="checkbox">
                        Active
                    </label>

                    <label class="flex items-center gap-3">
                        <input v-model="form.is_featured" type="checkbox">
                        Featured
                    </label>

                    <label class="flex items-center gap-3">
                        <input v-model="form.is_recommended" type="checkbox">
                        Recommended
                    </label>

                    <label class="flex items-center gap-3">
                        <input v-model="form.is_coming_soon" type="checkbox">
                        Coming Soon
                    </label>

                    <label class="flex items-center gap-3">
                        <input v-model="form.requires_subscription" type="checkbox">
                        Requires Subscription
                    </label>

                    <label class="flex items-center gap-3">
                        <input v-model="form.show_on_dashboard" type="checkbox">
                        Show On Dashboard
                    </label>

                    <label class="flex items-center gap-3">
                        <input v-model="form.show_on_homepage" type="checkbox">
                        Show On Homepage
                    </label>

                </div>
            </div>

            <!-- Content Configuration -->

            <div class="rounded-[2rem] border border-[#131747]/10 bg-white p-8 shadow-sm">
                <h3 class="text-xl font-black text-[#131747]">
                    Content Configuration
                </h3>

                <textarea v-model="form.content_json" rows="18"
                    class="mt-6 w-full rounded-xl border border-[#131747]/10 bg-[#131747]/[0.02] p-4 font-mono text-sm" />
            </div>

            <!-- Actions -->

            <div class="
                sticky
                bottom-4
                z-20
                flex
                justify-end
                gap-3
                rounded-2xl
                border
                border-[#131747]/10
                bg-white
                p-4
                shadow-xl
            ">
                <Link :href="route('admin.tools.index')"
                    class="rounded-xl border border-[#131747]/10 px-6 py-3 font-bold text-[#131747]">
                    Cancel
                </Link>

                <PrimaryButton :disabled="form.processing" class="px-8 py-3">
                    Create Tool
                </PrimaryButton>
            </div>

        </form>

    </AdminLayout>
</template>
