<script setup>
import { computed, ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link, usePage } from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);
const page = usePage();
const user = computed(() => page.props.auth.user ?? {});
const subscription = computed(() => page.props.auth.subscription ?? {});
const flash = computed(() => page.props.flash ?? {});
const isAdmin = computed(() => user.value?.is_admin ?? false);
</script>

<template>
    <div class="min-h-screen bg-[linear-gradient(180deg,#ffffff_0%,rgba(19,23,71,0.04)_100%)] text-[#131747]">
        <nav class="sticky top-0 z-50 border-b border-[#131747]/10 bg-white/90 backdrop-blur-xl">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex min-h-[4.75rem] items-center justify-between gap-4">
                    <div class="flex items-center gap-6">
                        <Link :href="route('home')" class="flex items-center gap-3">
                            <ApplicationLogo class="max-h-12 w-12" />
                        </Link>

                        <div class="hidden items-center gap-8 sm:flex">
                            <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
                                Dashboard
                            </NavLink>
                            <NavLink :href="route('history')" :active="route().current('history')">
                                Audit History
                            </NavLink>

                            <NavLink :href="route('billing.index')" :active="route().current('billing.*')">
                                Billing
                            </NavLink>
                            <NavLink
                                v-if="isAdmin"
                                :href="route('admin.dashboard')"
                                :active="route().current('admin.*')"
                            >
                                Admin
                            </NavLink>
                        </div>
                    </div>

                    <div class="hidden items-center gap-3 sm:flex">
                        <div class="hidden rounded-2xl border border-[#131747]/10 bg-[#131747]/5 px-4 py-2 lg:block">
                            <p class="text-[10px] font-semibold uppercase tracking-[0.28em] text-[#131747]/45">
                                Current plan
                            </p>
                            <div class="mt-1 flex items-center gap-2">
                                <span class="text-sm font-semibold text-[#131747]">
                                    {{ subscription.plan_name }}
                                </span>
                                <span class="rounded-full bg-[#FF4040]/10 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-[0.2em] text-[#FF4040]">
                                    {{ subscription.status }}
                                </span>
                            </div>
                        </div>

                        <div class="relative">
                            <Dropdown align="right" width="48">
                                <template #trigger>
                                    <span class="inline-flex rounded-md">
                                        <button
                                            type="button"
                                            class="inline-flex items-center gap-3 rounded-2xl border border-[#131747]/10 bg-white px-3 py-2 text-sm font-medium text-[#131747] shadow-sm shadow-[#131747]/5 transition duration-150 ease-in-out hover:border-[#FF4040]/30 hover:text-[#FF4040] focus:outline-none"
                                        >
                                            <span class="flex h-9 w-9 items-center justify-center rounded-full bg-[#131747] text-xs font-bold uppercase tracking-[0.2em] text-white">
                                                {{ user.initials }}
                                            </span>
                                            <span class="hidden text-left lg:block">
                                                <span class="block text-sm font-semibold leading-4">{{ user.name }}</span>
                                                <span class="mt-1 block text-xs text-[#131747]/50">{{ user.email }}</span>
                                            </span>

                                            <svg
                                                class="h-4 w-4"
                                                xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20"
                                                fill="currentColor"
                                            >
                                                <path
                                                    fill-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                    clip-rule="evenodd"
                                                />
                                            </svg>
                                        </button>
                                    </span>
                                </template>

                                <template #content>
                                    <DropdownLink :href="route('profile.edit')">
                                        Profile
                                    </DropdownLink>
                                    <DropdownLink :href="route('billing.index')">
                                        Billing Center
                                    </DropdownLink>
                                    <DropdownLink v-if="isAdmin" :href="route('admin.dashboard')">
                                        Admin Panel
                                    </DropdownLink>
                                    <DropdownLink :href="route('logout')" method="post" as="button">
                                        Log Out
                                    </DropdownLink>
                                </template>
                            </Dropdown>
                        </div>
                    </div>

                    <div class="-me-2 flex items-center sm:hidden">
                        <button
                            @click="showingNavigationDropdown = !showingNavigationDropdown"
                            class="inline-flex items-center justify-center rounded-xl border border-[#131747]/10 bg-white p-2 text-[#131747]/70 transition duration-150 ease-in-out hover:border-[#FF4040]/30 hover:text-[#FF4040] focus:outline-none"
                        >
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path
                                    :class="{
                                        hidden: showingNavigationDropdown,
                                        'inline-flex': !showingNavigationDropdown,
                                    }"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"
                                />
                                <path
                                    :class="{
                                        hidden: !showingNavigationDropdown,
                                        'inline-flex': showingNavigationDropdown,
                                    }"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"
                                />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div
                :class="{
                    block: showingNavigationDropdown,
                    hidden: !showingNavigationDropdown,
                }"
                class="border-t border-[#131747]/10 bg-white sm:hidden"
            >
                <div class="space-y-1 px-4 pb-3 pt-2">
                    <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                        Dashboard
                    </ResponsiveNavLink>
                    <ResponsiveNavLink :href="route('history')" :active="route().current('history')">
                        Audit History
                    </ResponsiveNavLink>

                    <ResponsiveNavLink :href="route('billing.index')" :active="route().current('billing.*')">
                        Billing
                    </ResponsiveNavLink>
                    <ResponsiveNavLink
                        v-if="isAdmin"
                        :href="route('admin.dashboard')"
                        :active="route().current('admin.*')"
                    >
                        Admin
                    </ResponsiveNavLink>
                </div>

                <div class="border-t border-[#131747]/10 px-4 pb-4 pt-4">
                    <div class="flex items-center gap-3">
                        <div class="flex h-11 w-11 items-center justify-center rounded-full bg-[#131747] text-sm font-bold uppercase tracking-[0.2em] text-white">
                            {{ user.initials }}
                        </div>
                        <div>
                            <div class="text-base font-semibold text-[#131747]">{{ user.name }}</div>
                            <div class="text-sm text-[#131747]/55">{{ user.email }}</div>
                        </div>
                    </div>

                    <div class="mt-4 rounded-2xl border border-[#131747]/10 bg-[#131747]/5 px-4 py-3">
                        <p class="text-[10px] font-semibold uppercase tracking-[0.28em] text-[#131747]/45">
                            Current plan
                        </p>
                        <div class="mt-2 flex items-center justify-between gap-3">
                            <span class="text-sm font-semibold text-[#131747]">{{ subscription.plan_name }}</span>
                            <span class="rounded-full bg-[#FF4040]/10 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-[0.2em] text-[#FF4040]">
                                {{ subscription.status }}
                            </span>
                        </div>
                    </div>

                    <div class="mt-3 space-y-1">
                        <ResponsiveNavLink :href="route('profile.edit')">
                            Profile
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('logout')" method="post" as="button">
                            Log Out
                        </ResponsiveNavLink>
                    </div>
                </div>
            </div>
        </nav>

        <div v-if="flash.success || flash.error" class="border-b border-[#131747]/10 bg-white/80">
            <div class="mx-auto max-w-7xl space-y-3 px-4 py-4 sm:px-6 lg:px-8">
                <div
                    v-if="flash.success"
                    class="rounded-2xl border border-[#131747]/10 bg-[#131747]/5 px-4 py-3 text-sm font-medium text-[#131747]"
                >
                    {{ flash.success }}
                </div>
                <div
                    v-if="flash.error"
                    class="rounded-2xl border border-[#FF4040]/20 bg-[#FF4040]/8 px-4 py-3 text-sm font-medium text-[#FF4040]"
                >
                    {{ flash.error }}
                </div>
            </div>
        </div>

        <header v-if="$slots.header" class="border-b border-[#131747]/10 bg-white/70 backdrop-blur-sm">
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                <slot name="header" />
            </div>
        </header>

        <main>
            <slot />
        </main>
    </div>
</template>
