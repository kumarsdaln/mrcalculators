<script setup>
    import { Link } from '@inertiajs/vue3';
    import { ChevronRight, ArrowUpRight, Lock } from 'lucide-vue-next';

    const props = defineProps({
        calculator: {
            type: Object,
            required: true,
        },

        icon: {
            type: [Object, Function],
            required: true,
        },

        hasAccess: {
            type: Boolean,
            default: false,
        },

        href: {
            type: String,
            required: true,
        },
    });
</script>

<template>
    <div class="
            group
            relative
            flex
            flex-col
            justify-between
            rounded-[2rem]
            border
            border-[#131747]/5
            bg-white
            p-8
            shadow-sm
            transition-all
            duration-300
            hover:-translate-y-1
            hover:shadow-xl
            hover:shadow-[#131747]/5
        ">
        <div>
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div class="
                        flex
                        h-14
                        w-14
                        items-center
                        justify-center
                        rounded-2xl
                        bg-[#131747]/5
                        text-[#131747]
                        transition-all
                        group-hover:bg-[#131747]
                        group-hover:text-white
                    ">
                    <component :is="icon" class="h-7 w-7" />
                </div>

                <span class="rounded-full px-3 py-1 text-[9px] font-black uppercase tracking-widest flex items-center gap-1"
                    :class="hasAccess
                            ? 'bg-emerald-50 text-emerald-600'
                            : 'bg-red-50 text-red-500'
                        ">
                    <template v-if="hasAccess">
                        {{ calculator.tag }}
                    </template>

                    <template v-else>
                        <Lock class="w-5" />
                    </template>
                </span>
            </div>

            <!-- Content -->
            <div class="mt-8">
                <h3 class="
                        text-xl
                        font-black
                        tracking-tight
                        text-[#131747]
                    ">
                    {{ calculator.title }}
                </h3>

                <p v-if="calculator.subtitle" class="
                        mt-2
                        text-sm
                        font-medium
                        text-[#FF4040]
                    ">
                    {{ calculator.subtitle }}
                </p>

                <p class="
                        mt-4
                        text-sm
                        leading-relaxed
                        text-[#131747]/60
                    ">
                    {{ calculator.description }}
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-10">
            <Link :href="href" class="
                    inline-flex
                    w-full
                    items-center
                    justify-between
                    rounded-xl
                    px-5
                    py-4
                    text-sm
                    font-bold
                    transition-all
                " :class="hasAccess
                    ? 'bg-[#131747] text-white hover:bg-[#FF4040]'
                    : 'bg-[#131747]/5 text-[#131747]/40'
                    ">
                <span>
                    {{
                        hasAccess
                            ? calculator.cta?.button_text || 'Use Calculator'
                            : calculator.cta?.locked_text || 'Unlock Calculator'
                    }}
                </span>

                <ChevronRight v-if="hasAccess" class="h-4 w-4" />

                <ArrowUpRight v-else class="h-4 w-4" />
            </Link>
        </div>
    </div>
</template>