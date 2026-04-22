<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    active: {
        type: String,
        required: true,
    }
});

const tabs = [
    { name: 'Overview', route: 'admin.dashboard' },
    { name: 'Plans', route: 'admin.plans' },
    { name: 'Users', route: 'admin.users' },
    { name: 'Subscriptions', route: 'admin.subscriptions' },
];
</script>

<template>
    <div class="border-b border-[#131747]/10 flex gap-6 overflow-x-auto">
        <Link 
            v-for="tab in tabs" 
            :key="tab.name"
            :href="route(tab.route)"
            :class="[
                'pb-4 text-sm font-bold uppercase tracking-wider transition-colors whitespace-nowrap border-b-2',
                active === tab.name 
                    ? 'border-[#FF4040] text-[#131747]' 
                    : 'border-transparent text-[#131747]/40 hover:text-[#131747]/70 hover:border-[#131747]/20'
            ]"
        >
            {{ tab.name }}
        </Link>
    </div>
</template>
