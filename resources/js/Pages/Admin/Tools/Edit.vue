<script setup>
    import AdminLayout from '@/Layouts/AdminLayout.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import { Head, Link, useForm } from '@inertiajs/vue3';

    const props = defineProps({
        tool: { type: Object, required: true },
    });

    const form = useForm({
        title: props.tool.title ?? '',
        slug: props.tool.slug ?? '',
        subtitle: props.tool.subtitle ?? '',
        description: props.tool.description ?? '',
        short_description: props.tool.short_description ?? '',
        icon: props.tool.icon ?? 'Calculator',
        route: props.tool.route ?? '',
        category: props.tool.category ?? '',
        tag: props.tool.tag ?? '',
        badge: props.tool.badge ?? '',
        is_active: props.tool.is_active ?? true,
        is_featured: props.tool.is_featured ?? false,
        is_recommended: props.tool.is_recommended ?? false,
        is_coming_soon: props.tool.is_coming_soon ?? false,
        requires_subscription: props.tool.requires_subscription ?? false,
        display_order: props.tool.display_order ?? 0,
        show_on_dashboard: props.tool.show_on_dashboard ?? true,
        show_on_homepage: props.tool.show_on_homepage ?? true,
        content_json: props.tool.content_json ?? '{}',
    });

    const submit = () => form.patch(route('admin.tools.update', props.tool.id));
</script>

<template>

    <Head :title="`Edit ${tool.title}`" />

    <AdminLayout>
        <template #header>
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-[#FF4040]">
                    Calculator Management
                </p>

                <h1 class="mt-2 text-4xl font-black text-[#131747]">
                    Edit Tool
                </h1>

                <p class="mt-2 text-[#131747]/60">
                    Update calculator settings, visibility, content,
                    and access permissions.
                </p>
            </div>
        </template>

        <div class="space-y-8">
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

                        <input v-model="form.icon" placeholder="Icon"
                            class="rounded-xl border border-[#131747]/10 px-4 py-3">

                        <input v-model="form.route" placeholder="Route Name"
                            class="rounded-xl border border-[#131747]/10 px-4 py-3">

                        <input v-model="form.tag" placeholder="Tag"
                            class="rounded-xl border border-[#131747]/10 px-4 py-3">

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

                        <textarea v-model="form.description" rows="6" placeholder="Description"
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

                <!-- Content JSON -->

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
                    <Link :href="route('admin.tools.show', tool.id)"
                        class="rounded-xl border border-[#131747]/10 px-6 py-3 font-bold text-[#131747]">
                        View Tool
                    </Link>

                    <Link :href="route('admin.tools.index')"
                        class="rounded-xl border border-[#131747]/10 px-6 py-3 font-bold text-[#131747]">
                        Cancel
                    </Link>

                    <PrimaryButton :disabled="form.processing" class="px-8 py-3">
                        Save Changes
                    </PrimaryButton>
                </div>

            </form>

        </div>

    </AdminLayout>
</template>
