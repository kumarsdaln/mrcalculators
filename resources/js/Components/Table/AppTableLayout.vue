<script setup>
    defineProps({
        title: String,
        subtitle: String,
        total: Number,
        currentPage: Number,
        lastPage: Number,
    })
</script>

<template>
    <div class="
            rounded-[1.75rem]
            border
            border-[#131747]/10
            bg-white
            shadow-sm
            shadow-[#131747]/5
        ">
        <div class="
                border-b
                border-[#131747]/10
                px-8
                py-6
            ">
            <div class="
                    flex
                    flex-col
                    gap-4
                    md:flex-row
                    md:items-end
                    md:justify-between
                ">
                <div>
                    <p class="
                            text-xs
                            font-semibold
                            uppercase
                            tracking-[0.28em]
                            text-[#FF4040]
                        ">
                        {{ subtitle }}
                    </p>

                    <h3 class="
                            mt-2
                            text-2xl
                            font-bold
                            text-[#131747]
                        ">
                        {{ title }}
                    </h3>
                </div>

                <p class="
                        text-xs
                        font-bold
                        uppercase
                        tracking-widest
                        text-[#131747]/40
                    ">
                    {{ total }} records
                    •
                    Page {{ currentPage }}
                    of {{ lastPage }}
                </p>
            </div>
        </div>

        <slot name="filters" />

        <slot />

        <slot name="pagination" />
    </div>
</template>