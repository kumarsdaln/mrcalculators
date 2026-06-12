<script setup>
    import AdminSidebar from '@/Components/Admin/AdminSidebar.vue';
    import AdminTopbar from '@/Components/Admin/AdminTopbar.vue';
</script>

<template>
    <div class="h-screen overflow-hidden bg-[#F8F9FC]">

        <div class="flex h-full">

            <!-- Sidebar -->
            <AdminSidebar />

            <!-- Content -->
            <div class="flex min-w-0 flex-1 flex-col">

                <AdminTopbar />

                <main
                    class="flex-1 overflow-y-auto"
                >
                    <div class="mx-auto max-w-7xl p-6 lg:p-8">

                        <slot name="header" />

                        <div class="mt-8">
                            <slot />
                        </div>

                    </div>
                </main>

            </div>

        </div>

    </div>
</template>