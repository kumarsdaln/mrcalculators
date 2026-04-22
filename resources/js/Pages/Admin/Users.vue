<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import AdminNav from '@/Components/AdminNav.vue';
import { Head, router } from '@inertiajs/vue3';
import { reactive } from 'vue';

const props = defineProps({
    users: {
        type: Array,
        required: true,
    },
    pagination: {
        type: Object,
        required: true,
    }
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
</script>

<template>
    <Head title="Admin Users" />

    <AuthenticatedLayout>
        <template #header>
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-[#FF4040]">
                    Operations workspace
                </p>
                <h2 class="mt-2 text-2xl font-bold leading-tight text-[#131747]">
                    Admin Command Center
                </h2>
            </div>
        </template>

        <div class="py-10">
            <div class="mx-auto max-w-7xl space-y-8 px-4 sm:px-6 lg:px-8">
                
                <AdminNav active="Users" />

                <!-- USERS TAB -->
                <div class="space-y-8 animate-fade-in">
                    <div class="rounded-[1.75rem] border border-[#131747]/10 bg-white p-8 shadow-sm shadow-[#131747]/5">
                        <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between border-b border-[#131747]/10 pb-4 gap-4">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-[#FF4040]">
                                    Identity Access Management
                                </p>
                                <h3 class="mt-2 text-2xl font-bold text-[#131747]">User Roles and Profiles</h3>
                            </div>
                            <p class="text-xs font-bold text-[#131747]/40 uppercase tracking-widest">Showing page {{ pagination.current_page }} of {{ pagination.last_page }}</p>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b-2 border-[#131747]/10">
                                        <th class="py-3 px-4 text-xs font-bold uppercase tracking-wider text-[#131747]/50">Identity</th>
                                        <th class="py-3 px-4 text-xs font-bold uppercase tracking-wider text-[#131747]/50">Status / Plan</th>
                                        <th class="py-3 px-4 text-xs font-bold uppercase tracking-wider text-[#131747]/50">Access Role</th>
                                        <th class="py-3 px-4 text-xs font-bold uppercase tracking-wider text-[#131747]/50 text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="user in users" :key="user.id" class="border-b border-[#131747]/5 hover:bg-[#131747]/[0.02] transition-colors group">
                                        <td class="py-4 px-4">
                                            <p class="text-sm font-bold text-[#131747]">{{ user.name }}</p>
                                            <p class="text-xs text-[#131747]/50 font-mono mt-0.5">{{ user.email }}</p>
                                        </td>
                                        <td class="py-4 px-4">
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-widest" :class="user.subscription.status === 'active' ? 'bg-[#131747]/10 text-[#131747]' : 'bg-[#FF4040]/10 text-[#FF4040]'">
                                                <span class="w-1.5 h-1.5 rounded-full" :class="user.subscription.status === 'active' ? 'bg-[#131747]' : 'bg-[#FF4040]'"></span>
                                                {{ user.subscription.plan_name }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-4">
                                            <select
                                                v-model="userRoles[user.id]"
                                                class="rounded-lg border border-[#131747]/20 bg-white py-1.5 px-3 text-xs font-bold uppercase tracking-wider text-[#131747] focus:border-[#FF4040] focus:ring-0 shadow-sm"
                                            >
                                                <option value="user">Standard User</option>
                                                <option value="admin">System Admin</option>
                                            </select>
                                        </td>
                                        <td class="py-4 px-4 text-right">
                                            <button @click="saveUser(user.id)" class="text-[10px] font-bold uppercase tracking-widest px-4 py-2 bg-[#131747] text-white rounded-lg hover:bg-[#FF4040] transition shadow-sm opacity-0 group-hover:opacity-100 focus:opacity-100 focus:outline-none">
                                                Update
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style>
.animate-fade-in {
    animation: fadeIn 0.3s ease-in-out;
}
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(5px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
