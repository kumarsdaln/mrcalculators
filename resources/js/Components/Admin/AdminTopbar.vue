<script setup>
    import { usePage } from '@inertiajs/vue3';
    import { Bell } from 'lucide-vue-next';

    const page = usePage();
</script>

<template>
    <header class="flex h-20 items-center justify-between border-b border-[#131747]/10 bg-white px-6">

        <div>

            <input type="text" placeholder="Search..."
                class="w-80 rounded-xl border border-[#131747]/10 px-4 py-2 focus:border-[#FF4040]" />

        </div>

        <div class="flex items-center gap-5">

            <button class="relative">
                <Bell class="h-5 w-5 text-[#131747]" />

                <span class="absolute -right-1 -top-1 h-2 w-2 rounded-full bg-[#FF4040]" />
            </button>

            <div class="flex items-center gap-3">

                <div
                    class="flex h-10 w-10 items-center justify-center rounded-full bg-[#131747]/10 font-black text-[#131747]">
                    {{ page.props.auth.user.name.charAt(0) }}
                </div>

                <div>
                    <p class="font-bold text-[#131747]">
                        {{ page.props.auth.user.name }}
                    </p>

                    <p class="text-xs text-[#131747]/50">
                        Administrator
                    </p>
                </div>

            </div>

        </div>

    </header>
</template>