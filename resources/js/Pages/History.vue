<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head } from '@inertiajs/vue3';
    import { defineProps } from 'vue';

    const props = defineProps({
        histories: Array
    });

    const formatDate = (dateString) => {
        return new Date(dateString).toLocaleDateString(undefined, {
            year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit'
        });
    };

    const formatType = (type) => {
        switch (type) {
            case 'monthly_sales_goal': return 'Monthly Sales Goal';
            case 'break_even_price': return 'Break-Even Price';
            case 'future_sales_forecast': return 'Sales Forecast';
            case 'ltv_cac_ratio': return 'LTV to CAC Ratio';
            default: return type.replace(/_/g, ' ');
        }
    }
</script>

<template>

    <Head title="Calculation History" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center gap-3">
                <h2 class="font-bold text-2xl text-[#131747] leading-tight">Calculation History</h2>
            </div>
        </template>

        <div class="py-12 bg-transparent min-h-screen">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <div class="mb-8 pl-2">
                    <h3 class="text-3xl font-extrabold text-[#131747] mb-2">Your Past Calculations</h3>
                    <p class="text-[#131747]/70 text-lg">A history of all the calculations you've run.</p>
                </div>

                <div
                    class="bg-white rounded-[2rem] shadow-lg shadow-[#131747]/5 border border-[#131747]/10 overflow-hidden">
                    <div
                        class="p-6 md:px-10 md:py-6 border-b border-[#131747]/10 bg-[#131747]/5 flex justify-between items-center">
                        <span class="font-bold text-[#131747]/60 uppercase tracking-[0.2em] text-xs">Saved
                            History</span>
                        <div class="flex gap-2">
                            <span class="h-2 w-2 rounded-full bg-[#131747]/20"></span>
                            <span class="h-2 w-2 rounded-full bg-[#131747]/20"></span>
                            <span class="h-2 w-2 rounded-full bg-[#FF4040]"></span>
                        </div>
                    </div>

                    <div class="p-6 md:p-10">
                        <div v-if="!histories || histories.length === 0"
                            class="text-[#131747]/50 text-center py-20 bg-[#131747]/[0.02] border border-dashed border-[#131747]/20 rounded-2xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-[#131747]/30 mb-4"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p class="font-bold text-[#131747] text-lg">No calculation records found.</p>
                            <p class="text-sm mt-1">Navigate to the dashboard and use a calculator to see history here.
                            </p>
                        </div>

                        <div v-else class="space-y-10">
                            <div v-for="history in histories" :key="history.id">

                                <div
                                    class="bg-white border-2 border-[#131747]/10 rounded-2xl overflow-hidden shadow-sm hover:border-[#131747]/30 transition-colors">
                                    <div
                                        class="bg-[#131747]/5 border-b border-[#131747]/10 px-8 py-5 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                                        <div>
                                            <div
                                                class="inline-block px-3 py-1 bg-[#131747] text-white text-[10px] font-bold uppercase tracking-[0.2em] rounded-md shadow-sm mb-3">
                                                {{ formatType(history.calculator_type) }}
                                            </div>
                                            <p
                                                class="text-sm text-[#131747]/60 font-mono font-bold flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                {{ formatDate(history.created_at) }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-10">

                                        <!-- Parsed Inputs visually -->
                                        <div class="space-y-6">
                                            <h4
                                                class="text-xs font-bold text-[#131747]/50 uppercase tracking-[0.2em] flex items-center gap-2 border-b border-[#131747]/10 pb-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                                What You Entered
                                            </h4>

                                            <!-- Handle depending on type -->
                                            <div v-if="history.calculator_type === 'monthly_sales_goal'"
                                                class="space-y-2">
                                                <div
                                                    class="flex justify-between bg-white border border-[#131747]/10 p-4 rounded-xl shadow-sm">
                                                    <span class="text-sm text-[#131747]/70 font-bold">Annual
                                                        Target</span>
                                                    <span class="text-sm font-mono text-[#131747] font-extrabold">${{
                                                        history.input_data.yearly_sale }}</span>
                                                </div>
                                            </div>

                                            <div v-else-if="history.calculator_type === 'break_even_price'"
                                                class="space-y-3">
                                                <div
                                                    class="flex justify-between items-center text-[10px] font-bold text-[#131747]/50 uppercase mb-1 px-2">
                                                    <span>Entry Details</span>
                                                    <span>Cost | Vol | Profit</span>
                                                </div>

                                                <!-- Loop through history.input_data directly as it is now the $entries array -->
                                                <div v-for="(entry, i) in history.input_data" :key="i"
                                                    class="bg-white p-3 px-4 rounded-xl border border-[#131747]/10 shadow-sm flex justify-between items-center transition-colors hover:border-[#131747]/30">

                                                    <div class="flex flex-col">
                                                        <span
                                                            class="text-[10px] text-[#131747]/40 font-mono font-bold uppercase">Entry
                                                            #{{ i + 1 }}</span>
                                                        <span class="text-sm font-mono text-[#131747] font-bold">${{
                                                            entry.amount }}</span>
                                                    </div>

                                                    <div class="text-right">
                                                        <div class="text-xs font-bold text-[#131747]/70">
                                                            {{ entry.unit }} Units
                                                        </div>
                                                        <!-- Individual Profit Goal saved in input_data -->
                                                        <div
                                                            class="inline-block text-[9px] bg-[#FF4040]/10 text-[#FF4040] px-2 py-0.5 rounded font-black uppercase mt-1">
                                                            +{{ entry.tpt }}% Goal
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div v-else-if="history.calculator_type === 'future_sales_forecast'"
                                                class="space-y-2">
                                                <div class="flex flex-wrap gap-3">
                                                    <div v-for="(amt, i) in history.input_data.month" :key="i"
                                                        class="bg-white p-4 rounded-xl border border-[#131747]/10 shadow-sm flex flex-col items-center flex-1 min-w-[80px]">
                                                        <span
                                                            class="text-[10px] text-[#131747]/50 font-bold uppercase mb-2 tracking-widest">Month
                                                            {{ i + 1 }}</span>
                                                        <span
                                                            class="text-sm font-mono font-extrabold text-[#131747]">${{
                                                                amt
                                                            }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div v-else-if="history.calculator_type === 'ltv_cac_ratio'"
                                                class="space-y-2">
                                                <div class="grid grid-cols-2 gap-3">
                                                    <div
                                                        class="bg-white p-4 rounded-xl border border-[#131747]/10 shadow-sm flex flex-col">
                                                        <span
                                                            class="text-[10px] text-[#131747]/50 uppercase font-bold tracking-widest mb-2">Marketing
                                                            Spend</span>
                                                        <span
                                                            class="font-mono font-extrabold text-sm text-[#131747]">${{
                                                                history.input_data.marketing_spend }}</span>
                                                    </div>
                                                    <div
                                                        class="bg-white p-4 rounded-xl border border-[#131747]/10 shadow-sm flex flex-col">
                                                        <span
                                                            class="text-[10px] text-[#131747]/50 uppercase font-bold tracking-widest mb-2">New
                                                            Customers</span>
                                                        <span class="font-mono font-extrabold text-sm text-[#131747]">{{
                                                            history.input_data.new_customers }} Customers</span>
                                                    </div>
                                                    <div
                                                        class="bg-white p-4 rounded-xl border border-[#131747]/10 shadow-sm flex flex-col">
                                                        <span
                                                            class="text-[10px] text-[#131747]/50 uppercase font-bold tracking-widest mb-2">Avg
                                                            Revenue</span>
                                                        <span
                                                            class="font-mono font-extrabold text-sm text-[#131747]">${{
                                                                history.input_data.avg_revenue }}</span>
                                                    </div>
                                                    <div
                                                        class="bg-white p-4 rounded-xl border border-[#131747]/10 shadow-sm flex flex-col">
                                                        <span
                                                            class="text-[10px] text-[#131747]/50 uppercase font-bold tracking-widest mb-2">Lifetime
                                                            (Months)</span>
                                                        <span class="font-mono font-extrabold text-sm text-[#131747]">{{
                                                            history.input_data.customer_lifetime }} months</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div v-else
                                                class="bg-[#131747]/5 p-5 rounded-xl text-xs font-mono text-[#131747]/60 border border-[#131747]/10 overflow-x-auto">
                                                {{ JSON.stringify(history.input_data) }}
                                            </div>
                                        </div>

                                        <!-- Parsed Results visually -->
                                        <div class="space-y-6">
                                            <h4
                                                class="text-xs font-bold text-[#131747]/50 uppercase tracking-[0.2em] flex items-center gap-2 border-b border-[#131747]/10 pb-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                                </svg>
                                                The Result
                                            </h4>

                                            <div
                                                class="bg-[#131747] border border-[#131747] p-8 rounded-2xl h-[calc(100%-3rem)] flex flex-col justify-center shadow-[0_20px_40px_-15px_rgba(19,23,71,0.4)] relative overflow-hidden">
                                                <div
                                                    class="absolute inset-0 bg-[radial-gradient(ellipse_at_bottom_right,_rgba(255,64,64,0.2),_transparent_60%)] z-0">
                                                </div>

                                                <div class="relative z-10 w-full"
                                                    v-if="history.calculator_type === 'monthly_sales_goal'">
                                                    <p
                                                        class="text-[10px] text-[#FF4040] font-bold tracking-[0.2em] uppercase mb-2">
                                                        Monthly Goal</p>
                                                    <p
                                                        class="text-4xl lg:text-5xl font-mono font-extrabold text-white break-words drop-shadow-sm">
                                                        ${{ history.result_data.monthly_sale }}</p>
                                                </div>

                                                <div class="relative z-10 w-full space-y-5"
                                                    v-else-if="history.calculator_type === 'break_even_price'">
                                                    <!-- Loop through result_data which is the $calculatedData array -->
                                                    <div v-for="(res, idx) in history.result_data" :key="idx"
                                                        class="pb-4 border-b border-white/10 last:border-0 last:pb-0 last:mb-0">

                                                        <div class="flex items-center justify-between mb-3">
                                                            <span
                                                                class="text-[9px] font-black bg-[#FF4040] text-white px-2 py-0.5 rounded uppercase tracking-tighter">
                                                                Row {{ res.entry_no }}
                                                            </span>
                                                            <span
                                                                class="text-[9px] text-white/30 font-mono uppercase">Calculated
                                                                Output</span>
                                                        </div>

                                                        <div class="grid grid-cols-2 gap-4">
                                                            <div
                                                                class="bg-white/5 p-3 rounded-xl border border-white/5">
                                                                <p
                                                                    class="text-[9px] text-white/50 font-bold uppercase tracking-wider mb-1">
                                                                    Break-Even</p>
                                                                <p class="text-lg font-mono font-bold text-white">${{
                                                                    res.break_even_price }}</p>
                                                            </div>
                                                            <div
                                                                class="bg-[#FF4040]/10 p-3 rounded-xl border border-[#FF4040]/20">
                                                                <p
                                                                    class="text-[9px] text-[#FF4040] font-bold uppercase tracking-wider mb-1">
                                                                    Target Price</p>
                                                                <p class="text-lg font-mono font-black text-white">${{
                                                                    res.target_price }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="relative z-10 w-full"
                                                    v-else-if="history.calculator_type === 'future_sales_forecast'">
                                                    <p
                                                        class="text-[10px] text-[#FF4040] font-bold tracking-[0.2em] uppercase mb-2 flex items-center gap-2">
                                                        <span
                                                            class="h-1.5 w-1.5 rounded-full bg-[#FF4040] animate-pulse"></span>
                                                        Predicted Next Month
                                                    </p>
                                                    <p
                                                        class="text-4xl lg:text-5xl font-mono font-extrabold text-white break-words drop-shadow-sm">
                                                        ${{ history.result_data.forecast_future_sales }}</p>
                                                </div>

                                                <div class="relative z-10 w-full space-y-4"
                                                    v-else-if="history.calculator_type === 'ltv_cac_ratio'">
                                                    <div class="grid grid-cols-2 gap-6 pb-6 border-b border-white/10">
                                                        <div>
                                                            <p
                                                                class="text-[10px] text-white/50 font-bold uppercase tracking-[0.1em] mb-1">
                                                                CAC</p>
                                                            <p class="text-xl font-mono font-bold text-white/90">${{
                                                                history.result_data.cac }}</p>
                                                        </div>
                                                        <div>
                                                            <p
                                                                class="text-[10px] text-white/50 font-bold uppercase tracking-[0.1em] mb-1">
                                                                LTV</p>
                                                            <p class="text-xl font-mono font-bold text-white/90">${{
                                                                history.result_data.ltv }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="pt-2">
                                                        <p
                                                            class="text-[10px] text-[#FF4040] font-bold uppercase tracking-[0.2em] mb-2">
                                                            LTV to CAC Ratio</p>
                                                        <p
                                                            class="text-5xl lg:text-6xl font-mono font-extrabold text-white drop-shadow-sm">
                                                            {{ history.result_data.ratio }}:1</p>
                                                    </div>
                                                </div>

                                                <div class="relative z-10 w-full" v-else>
                                                    <pre class="text-xs text-white/70 font-mono whitespace-pre-wrap">{{
                                                        JSON.stringify(history.result_data, null, 2) }}</pre>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
