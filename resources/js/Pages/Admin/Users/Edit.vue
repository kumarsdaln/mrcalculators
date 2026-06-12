<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    user: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    name: props.user.name,
    email: props.user.email,
    company_name: props.user.company_name || '',
    phone: props.user.phone || '',
    role: props.user.role,
});

const submit = () => {
    form.patch(route('admin.users.update', props.user.id));
};
</script>

<template>
    <Head title="Edit User" />

    <AdminLayout>

        <template #header>
            <div>
                <p
                    class="text-xs font-semibold uppercase tracking-[0.3em] text-[#FF4040]"
                >
                    User Management
                </p>

                <h1
                    class="mt-2 text-4xl font-black text-[#131747]"
                >
                    Edit User
                </h1>

                <p
                    class="mt-2 text-[#131747]/60"
                >
                    Update account information, company details, and user access.
                </p>
            </div>
        </template>

        <div class="py-10">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-8">

                <!-- User Hero -->
                <div
                    class="relative overflow-hidden rounded-[2rem] bg-[#131747] p-8 text-white shadow-xl"
                >
                    <div
                        class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(255,64,64,0.3),_transparent_50%)]"
                    ></div>

                    <div
                        class="relative flex flex-col gap-5 sm:flex-row sm:items-center"
                    >
                        <div
                            class="flex h-20 w-20 items-center justify-center rounded-full bg-white/10 text-3xl font-black"
                        >
                            {{ form.name?.charAt(0)?.toUpperCase() }}
                        </div>

                        <div>
                            <h2
                                class="text-3xl font-black"
                            >
                                {{ form.name }}
                            </h2>

                            <p
                                class="mt-1 text-white/70"
                            >
                                {{ form.email }}
                            </p>

                            <div
                                class="mt-3 inline-flex rounded-full bg-white/10 px-4 py-1 text-xs font-bold uppercase tracking-widest"
                            >
                                {{
                                    form.role === 'admin'
                                        ? 'System Administrator'
                                        : 'Standard User'
                                }}
                            </div>
                        </div>
                    </div>
                </div>

                <form @submit.prevent="submit">

                    <div class="grid gap-8 lg:grid-cols-3">

                        <!-- Main Form -->
                        <div class="lg:col-span-2 space-y-8">

                            <!-- Personal Information -->
                            <div
                                class="rounded-[2rem] border border-[#131747]/10 bg-white p-8 shadow-sm"
                            >
                                <h3
                                    class="text-xl font-black text-[#131747]"
                                >
                                    Personal Information
                                </h3>

                                <div class="mt-6 grid gap-5 md:grid-cols-2">

                                    <!-- Name -->
                                    <div>
                                        <label
                                            class="mb-2 block text-sm font-bold text-[#131747]"
                                        >
                                            Full Name
                                        </label>

                                        <input
                                            v-model="form.name"
                                            type="text"
                                            class="w-full rounded-xl border border-[#131747]/10 px-4 py-3 focus:border-[#FF4040] focus:ring-[#FF4040]/20"
                                        >

                                        <p
                                            v-if="form.errors.name"
                                            class="mt-1 text-sm text-red-500"
                                        >
                                            {{ form.errors.name }}
                                        </p>
                                    </div>

                                    <!-- Email -->
                                    <div>
                                        <label
                                            class="mb-2 block text-sm font-bold text-[#131747]"
                                        >
                                            Email Address
                                        </label>

                                        <input
                                            v-model="form.email"
                                            type="email"
                                            class="w-full rounded-xl border border-[#131747]/10 px-4 py-3 focus:border-[#FF4040] focus:ring-[#FF4040]/20"
                                        >

                                        <p
                                            v-if="form.errors.email"
                                            class="mt-1 text-sm text-red-500"
                                        >
                                            {{ form.errors.email }}
                                        </p>
                                    </div>

                                    <!-- Phone -->
                                    <div class="md:col-span-2">
                                        <label
                                            class="mb-2 block text-sm font-bold text-[#131747]"
                                        >
                                            Phone Number
                                        </label>

                                        <input
                                            v-model="form.phone"
                                            type="text"
                                            class="w-full rounded-xl border border-[#131747]/10 px-4 py-3 focus:border-[#FF4040] focus:ring-[#FF4040]/20"
                                        >

                                        <p
                                            v-if="form.errors.phone"
                                            class="mt-1 text-sm text-red-500"
                                        >
                                            {{ form.errors.phone }}
                                        </p>
                                    </div>

                                </div>
                            </div>

                            <!-- Account Settings -->
                            <div
                                class="rounded-[2rem] border border-[#131747]/10 bg-white p-8 shadow-sm"
                            >
                                <h3
                                    class="text-xl font-black text-[#131747]"
                                >
                                    Account Settings
                                </h3>

                                <div class="mt-6 grid gap-5">

                                    <!-- Company -->
                                    <div>
                                        <label
                                            class="mb-2 block text-sm font-bold text-[#131747]"
                                        >
                                            Company Name
                                        </label>

                                        <input
                                            v-model="form.company_name"
                                            type="text"
                                            class="w-full rounded-xl border border-[#131747]/10 px-4 py-3 focus:border-[#FF4040] focus:ring-[#FF4040]/20"
                                        >

                                        <p
                                            v-if="form.errors.company_name"
                                            class="mt-1 text-sm text-red-500"
                                        >
                                            {{ form.errors.company_name }}
                                        </p>
                                    </div>

                                    <!-- Role -->
                                    <div>
                                        <label
                                            class="mb-2 block text-sm font-bold text-[#131747]"
                                        >
                                            User Role
                                        </label>

                                        <select
                                            v-model="form.role"
                                            class="w-full rounded-xl border border-[#131747]/10 px-4 py-3 font-semibold focus:border-[#FF4040] focus:ring-[#FF4040]/20"
                                        >
                                            <option value="user">
                                                Standard User
                                            </option>

                                            <option value="admin">
                                                System Administrator
                                            </option>
                                        </select>

                                        <p
                                            v-if="form.errors.role"
                                            class="mt-1 text-sm text-red-500"
                                        >
                                            {{ form.errors.role }}
                                        </p>
                                    </div>

                                </div>
                            </div>

                        </div>

                        <!-- Sidebar -->
                        <div class="space-y-6">

                            <div
                                class="rounded-[2rem] border border-[#131747]/10 bg-white p-8 shadow-sm"
                            >
                                <h3
                                    class="text-lg font-black text-[#131747]"
                                >
                                    Account Information
                                </h3>

                                <div
                                    class="mt-6 space-y-4 text-sm"
                                >

                                    <div class="flex justify-between">
                                        <span class="text-[#131747]/60">
                                            User ID
                                        </span>

                                        <span class="font-bold text-[#131747]">
                                            #{{ user.id }}
                                        </span>
                                    </div>

                                    <div class="flex justify-between">
                                        <span class="text-[#131747]/60">
                                            Role
                                        </span>

                                        <span class="font-bold text-[#131747]">
                                            {{ user.role }}
                                        </span>
                                    </div>

                                    <div
                                        v-if="user.created_at"
                                        class="flex justify-between"
                                    >
                                        <span class="text-[#131747]/60">
                                            Joined
                                        </span>

                                        <span class="font-bold text-[#131747]">
                                            {{ user.created_at }}
                                        </span>
                                    </div>

                                </div>
                            </div>

                            <div
                                class="rounded-[2rem] border border-[#FF4040]/10 bg-[#FF4040]/5 p-6"
                            >
                                <h3
                                    class="font-black text-[#131747]"
                                >
                                    Administrator Note
                                </h3>

                                <p
                                    class="mt-3 text-sm leading-6 text-[#131747]/70"
                                >
                                    Changes made here will immediately update the
                                    user's account information and access level.
                                </p>
                            </div>

                        </div>

                    </div>

                    <!-- Action Bar -->
                    <div
                        class="mt-8 flex flex-wrap justify-end gap-3"
                    >
                        <Link
                            :href="route('admin.users.show', props.user.id)"
                            class="rounded-xl border border-[#131747]/10 bg-white px-6 py-3 font-bold text-[#131747] transition hover:bg-[#131747]/5"
                        >
                            View Profile
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
        </div>

    </AdminLayout>
</template>