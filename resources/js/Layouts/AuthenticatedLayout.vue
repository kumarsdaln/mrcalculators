<script setup>
import { computed, ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link, usePage } from '@inertiajs/vue3';
import { 
    LayoutDashboard, 
    History, 
    CreditCard, 
    ShieldCheck, 
    LogOut, 
    User,
    Menu,
    X,
    Bell,
    ChevronDown,
    Sparkles
} from 'lucide-vue-next';

const showingNavigationDropdown = ref(false);
const page = usePage();
const user = computed(() => page.props.auth.user ?? {});
const subscription = computed(() => page.props.auth.subscription ?? {});
const flash = computed(() => page.props.flash ?? {});
const isAdmin = computed(() => user.value?.is_admin ?? false);
</script>

<template>
    <div class="min-h-screen bg-[#F8F9FB] text-[#131747] selection:bg-[#FF4040]/10 selection:text-[#FF4040]">
        
        <!-- Animated Background Accents -->
        <div class="fixed inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-[10%] -right-[5%] w-[40%] h-[40%] rounded-full bg-[#FF4040]/5 blur-[120px] animate-pulse"></div>
            <div class="absolute top-[20%] -left-[5%] w-[30%] h-[30%] rounded-full bg-[#131747]/5 blur-[100px]"></div>
        </div>

        <nav class="sticky top-0 z-50 border-b border-[#131747]/5 bg-white/80 backdrop-blur-xl">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex min-h-[5rem] items-center justify-between">
                    
                    <!-- Left Side: Brand & Primary Nav -->
                    <div class="flex items-center gap-12">
                        <Link :href="route('home')" class="group flex items-center transition-transform active:scale-95">
                            <ApplicationLogo class="max-h-24 w-20 w-auto" />
                        </Link>

                        <div class="hidden items-center gap-1 sm:flex">
                            <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
                                <LayoutDashboard :size="16" class="mr-2 opacity-50" />
                                Dashboard
                            </NavLink>
                            <NavLink :href="route('history')" :active="route().current('history')">
                                <History :size="16" class="mr-2 opacity-50" />
                                Audit History
                            </NavLink>
                            <NavLink :href="route('billing.index')" :active="route().current('billing.*')">
                                <CreditCard :size="16" class="mr-2 opacity-50" />
                                Billing
                            </NavLink>
                            <NavLink v-if="isAdmin" :href="route('admin.dashboard')" :active="route().current('admin.*')">
                                <ShieldCheck :size="16" class="mr-2 opacity-50" />
                                Admin
                            </NavLink>
                        </div>
                    </div>

                    <!-- Right Side: Plan & User -->
                    <div class="hidden items-center gap-4 sm:flex">
                        <!-- Premium Plan Badge -->
                        <div class="hidden items-center gap-3 rounded-2xl border border-[#131747]/5 bg-white px-4 py-2 shadow-sm lg:flex">
                            <div class="flex h-8 w-8 items-center justify-center rounded-xl bg-[#FF4040]/10 text-[#FF4040]">
                                <Sparkles :size="16" />
                            </div>
                            <div>
                                <p class="text-[9px] font-black uppercase tracking-widest text-[#131747]/40">Active Tier</p>
                                <p class="text-xs font-bold">{{ subscription.plan_name }}</p>
                            </div>
                        </div>

                        <div class="h-8 w-px bg-gray-100 mx-2"></div>

                        <!-- User Profile -->
                        <div class="relative">
                            <Dropdown align="right" width="56">
                                <template #trigger>
                                    <button class="group flex items-center gap-3 rounded-2xl bg-[#131747] p-1 pr-4 transition-all hover:bg-[#131747]/90 hover:shadow-lg hover:shadow-[#131747]/20">
                                        <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-white/10 text-xs font-black text-white">
                                            {{ user.initials }}
                                        </div>
                                        <div class="hidden text-left lg:block">
                                            <p class="text-[11px] font-bold leading-none text-white/60">Account</p>
                                            <p class="mt-1 text-xs font-bold text-white">{{ user.name }}</p>
                                        </div>
                                        <ChevronDown :size="14" class="text-white/40 transition-transform group-hover:translate-y-0.5" />
                                    </button>
                                </template>

                                <template #content>
                                    <div class="px-4 py-3 border-b border-gray-50">
                                        <p class="text-[10px] font-black uppercase tracking-widest text-gray-400">Personal Space</p>
                                    </div>
                                    <DropdownLink :href="route('profile.edit')" class="flex items-center gap-2">
                                        <User :size="14" class="opacity-50" /> Profile Settings
                                    </DropdownLink>
                                    <DropdownLink :href="route('billing.index')" class="flex items-center gap-2">
                                        <CreditCard :size="14" class="opacity-50" /> Subscription
                                    </DropdownLink>
                                    <div class="border-t border-gray-50 mt-1"></div>
                                    <DropdownLink :href="route('logout')" method="post" as="button" class="flex items-center gap-2 !text-[#FF4040]">
                                        <LogOut :size="14" /> Sign Out
                                    </DropdownLink>
                                </template>
                            </Dropdown>
                        </div>
                    </div>

                    <!-- Mobile Menu Button -->
                    <div class="-me-2 flex items-center sm:hidden">
                        <button @click="showingNavigationDropdown = !showingNavigationDropdown" class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-[#131747] text-white">
                            <Menu v-if="!showingNavigationDropdown" :size="20" />
                            <X v-else :size="20" />
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Navigation -->
            <transition enter-active-class="transition duration-200 ease-out" enter-from-class="translate-y-[-10px] opacity-0" enter-to-class="translate-y-0 opacity-100">
                <div v-show="showingNavigationDropdown" class="border-t border-[#131747]/5 bg-white sm:hidden">
                    <div class="space-y-1 px-4 pb-6 pt-4">
                        <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">Dashboard</ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('history')" :active="route().current('history')">Audit History</ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('billing.index')" :active="route().current('billing.*')">Billing Center</ResponsiveNavLink>
                        
                        <div class="mt-6 border-t border-gray-100 pt-6">
                            <div class="flex items-center gap-4 px-2">
                                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#131747] font-black text-white">
                                    {{ user.initials }}
                                </div>
                                <div>
                                    <p class="font-bold text-[#131747]">{{ user.name }}</p>
                                    <p class="text-xs text-[#131747]/50">{{ user.email }}</p>
                                </div>
                            </div>
                            <div class="mt-4 grid grid-cols-2 gap-2">
                                <Link :href="route('profile.edit')" class="flex items-center justify-center rounded-xl bg-gray-50 py-3 text-xs font-bold">Settings</Link>
                                <Link :href="route('logout')" method="post" as="button" class="flex items-center justify-center rounded-xl bg-[#FF4040]/5 py-3 text-xs font-bold text-[#FF4040]">Logout</Link>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
        </nav>

        <!-- Flash Messaging -->
        <div v-if="flash.success || flash.error" class="fixed bottom-8 right-8 z-[100] w-full max-w-md animate-bounce-in">
            <div v-if="flash.success" class="flex items-center gap-3 rounded-[2rem] border border-[#131747]/5 bg-white p-4 shadow-2xl shadow-[#131747]/10">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-emerald-500 text-white">
                    <ShieldCheck :size="20" />
                </div>
                <p class="text-sm font-bold text-[#131747]">{{ flash.success }}</p>
            </div>
            <div v-if="flash.error" class="flex items-center gap-3 rounded-[2rem] border border-[#FF4040]/10 bg-white p-4 shadow-2xl shadow-[#FF4040]/10">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#FF4040] text-white">
                    <ShieldCheck :size="20" />
                </div>
                <p class="text-sm font-bold text-[#FF4040]">{{ flash.error }}</p>
            </div>
        </div>

        <!-- Layout Header -->
        <header v-if="$slots.header" class="relative overflow-hidden pt-12 pb-8">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <slot name="header" />
            </div>
        </header>

        <!-- Content Area -->
        <main class="relative pb-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <slot />
            </div>
        </main>
    </div>
</template>

<style scoped>
@keyframes bounce-in {
    0% { transform: translateY(20px); opacity: 0; }
    100% { transform: translateY(0); opacity: 1; }
}
.animate-bounce-in {
    animation: bounce-in 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}
</style>