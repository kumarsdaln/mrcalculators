<script setup>
import { Link } from '@inertiajs/vue3';
import {
    LayoutDashboard,
    Users,
    CreditCard,
    Package,
    Calculator,
    Settings,
    Activity,
    Globe,
} from 'lucide-vue-next';

const menu = [
    {
        label: 'Dashboard',
        icon: LayoutDashboard,
        route: 'admin.dashboard',
    },
    {
        label: 'Users',
        icon: Users,
        route: 'admin.users.index',
    },
    {
        label: 'Plans',
        icon: Package,
        route: 'admin.plans.index',
    },
    {
        label: 'Subscriptions',
        icon: CreditCard,
        route: 'admin.subscriptions.index',
    },
    {
        label: 'Calculators',
        icon: Calculator,
        route: 'admin.tools.index',
    },
    // {
    //     label: 'Activity Logs',
    //     icon: Activity,
    //     route: 'admin.activity.index',
    // },
    // {
    //     label: 'Settings',
    //     icon: Settings,
    //     route: 'admin.settings',
    // },
];
</script>

<template>
    <aside
        class="hidden w-72 border-r border-[#131747]/10 bg-white lg:flex lg:flex-col"
    >

        <!-- Logo -->
        <div
            class="border-b border-[#131747]/10 p-6"
        >
            <Link
                :href="route('admin.dashboard')"
                class="flex items-center gap-4"
            >
                <div
                    class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#131747] text-lg font-black text-white"
                >
                    MR
                </div>

                <div>
                    <h2
                        class="font-black text-[#131747]"
                    >
                        MR Calculators
                    </h2>

                    <p
                        class="text-xs text-[#131747]/50"
                    >
                        Admin Panel
                    </p>
                </div>
            </Link>
        </div>

        <!-- Menu -->
        <div class="flex-1 p-4">

            <div class="space-y-2">

                <Link
                    v-for="item in menu"
                    :key="item.route"
                    :href="route(item.route)"
                    class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold text-[#131747]/70 transition hover:bg-[#131747]/5 hover:text-[#131747]"
                >
                    <component
                        :is="item.icon"
                        class="h-5 w-5"
                    />

                    {{ item.label }}
                </Link>

            </div>

        </div>

        <!-- Footer -->
        <div
            class="border-t border-[#131747]/10 p-4"
        >
            <Link
                :href="route('dashboard')"
                class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold text-[#131747]/70 hover:bg-[#131747]/5"
            >
                <Globe class="h-5 w-5" />
                View Website
            </Link>
        </div>

    </aside>
</template>