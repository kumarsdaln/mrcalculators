<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import Modal from '@/Components/Modal.vue';
    import { Head, Link } from '@inertiajs/vue3';
    import { ref } from 'vue';
    import axios from 'axios';
    import VueApexCharts from 'vue3-apexcharts';
    import { useCalculator } from '@/Composable/useCalculator';
    import CalculatorHero from '@/Components/Calculators/CalculatorHero.vue';
    import CalculatorHowToUse from '@/Components/Calculators/CalculatorHowToUse.vue';
    import CalculatorFAQ from '@/Components/Calculators/CalculatorFAQ.vue';
    import CalculatorResultsHelp from '@/Components/Calculators/CalculatorResultsHelp.vue';
    import CalculatorTips from '@/Components/Calculators/CalculatorTips.vue';

    const calculator = useCalculator('break_even_price');

    // Each row now tracks its own profit percentage (tpt)
    const months = ref([
        { amount: '', unit: '', tpt: 0 },
    ]);

    const results = ref([]);
    const errorMessage = ref('');
    const loading = ref(false);

    const chartOptions = ref({
        chart: { type: 'line', zoom: { enabled: false }, toolbar: { show: false }, fontFamily: 'sans-serif' },
        colors: ['#FF4040', '#131747'],
        stroke: { curve: 'straight', width: 3 },
        xaxis: { categories: ['Zero', 'Break-Even', 'Target'] },
        yaxis: { labels: { formatter: (val) => '$' + val.toFixed(0) } }
    });

    const series = ref([]);

    const addMonth = () => {
        months.value.push({ amount: '', unit: '', tpt: 0 });
    };

    const removeMonth = (index) => {
        if (months.value.length > 1) {
            months.value.splice(index, 1);
        }
    }

    const calculate = async () => {
        errorMessage.value = '';
        results.value = [];
        loading.value = true;

        try {
            // Sending the entire array of objects to the backend
            const response = await axios.post(route('api.calculator.break-even-and-selling-price'), {
                entries: months.value
            });

            if (response.data.status === 'success') {
                results.value = response.data.data;

                // Chart logic (visualizing the first entry as a reference)
                if (results.value.length > 0) {
                    const first = results.value[0];
                    series.value = [
                        {
                            name: 'Total Costs',
                            data: [first.expense, first.expense, first.expense]
                        },
                        {
                            name: 'Projected Revenue',
                            data: [0, parseFloat(first.expense), parseFloat(first.target_price) * first.units]
                        }
                    ];
                }
            } else {
                errorMessage.value = response.data.error;
            }
        } catch (e) {
            errorMessage.value = e.response?.data?.message || 'Calculation failed.';
        } finally {
            loading.value = false;
        }
    };
</script>

<template>

    <Head :title="calculator.seo.title" :description="calculator.seo.description" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center gap-4">
                <Link :href="route('dashboard')" class="text-[#131747]/60 hover:text-[#FF4040] transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </Link>
                <h2 class="font-bold text-2xl text-[#131747] leading-tight">{{ calculator.title }}</h2>
            </div>
        </template>
        <CalculatorHero :calculator="calculator"/>
        <div class="py-12 bg-transparent min-h-screen">
            <div class="space-y-8">
                <!-- Header Section -->
                <div
                    class="bg-white p-8 md:p-10 rounded-[2rem] shadow-lg shadow-[#131747]/5 border border-[#131747]/10">
                    <form @submit.prevent="calculate">
                        <div class="mb-8">
                            <!-- Table Headers -->
                            <div class="hidden md:grid grid-cols-12 gap-4 mb-4 pb-2 border-b border-[#131747]/10 px-2">
                                <div class="col-span-1 text-xs font-bold uppercase tracking-widest text-[#131747]/40">#
                                </div>
                                <div class="col-span-3 text-xs font-bold uppercase tracking-widest text-[#131747]/60">
                                    Total
                                    Costs ($)</div>
                                <div class="col-span-3 text-xs font-bold uppercase tracking-widest text-[#131747]/60">
                                    Units to
                                    Sell</div>
                                <div class="col-span-4 text-xs font-bold uppercase tracking-widest text-[#131747]/60">
                                    Profit
                                    Goal (%)</div>
                                <div class="col-span-1"></div>
                            </div>

                            <!-- Entry Rows -->
                            <div class="space-y-4">
                                <div v-for="(item, index) in months" :key="index"
                                    class="flex flex-col md:grid md:grid-cols-12 gap-4 items-center bg-[#131747]/[0.01] md:bg-transparent p-4 md:p-0 rounded-xl">
                                    <div
                                        class="col-span-12 md:col-span-1 font-mono text-[#131747]/40 font-bold text-sm">
                                        {{ index + 1 }}
                                    </div>
                                    <div class="col-span-12 md:col-span-3 w-full">
                                        <input type="number" step="0.01" v-model="item.amount" required
                                            class="w-full bg-[#131747]/[0.02] border border-[#131747]/10 rounded-xl py-3 px-4 text-[#131747] font-bold focus:ring-2 focus:ring-[#FF4040] focus:border-[#FF4040] font-mono"
                                            placeholder="Costs">
                                    </div>
                                    <div class="col-span-12 md:col-span-3 w-full">
                                        <input type="number" step="1" v-model="item.unit" required
                                            class="w-full bg-[#131747]/[0.02] border border-[#131747]/10 rounded-xl py-3 px-4 text-[#131747] font-bold focus:ring-2 focus:ring-[#FF4040] focus:border-[#FF4040] font-mono"
                                            placeholder="Units">
                                    </div>
                                    <div class="col-span-12 md:col-span-4 w-full relative">
                                        <input type="number" step="0.1" v-model="item.tpt" required
                                            class="w-full bg-[#131747]/[0.02] border border-[#131747]/10 rounded-xl py-3 px-4 text-[#131747] font-bold focus:ring-2 focus:ring-[#FF4040] focus:border-[#FF4040] font-mono"
                                            placeholder="Profit Margin">
                                        <span class="absolute right-4 top-3 text-[#131747]/30 font-bold">%</span>
                                    </div>
                                    <div class="col-span-12 md:col-span-1 w-full flex justify-end">
                                        <button v-if="months.length > 1" type="button" @click="removeMonth(index)"
                                            class="text-[#131747]/40 hover:text-[#FF4040] transition p-2 border border-[#131747]/10 rounded-xl bg-white">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6 pt-4 border-t border-[#131747]/10">
                                <button type="button" @click="addMonth"
                                    class="text-xs font-bold uppercase tracking-widest text-[#131747] hover:text-[#FF4040] transition flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg> Add Another Entry
                                </button>
                            </div>
                        </div>

                        <button type="submit" :disabled="loading"
                            class="w-full inline-flex items-center justify-center px-8 py-5 text-sm font-bold uppercase tracking-widest text-white transition-all duration-300 bg-[#131747] rounded-2xl hover:bg-[#FF4040] hover:shadow-xl disabled:opacity-50">
                            {{ loading ? 'Processing...' : 'Calculate All Results' }}
                        </button>

                        <div v-if="errorMessage"
                            class="mt-6 text-[#FF4040] bg-[#FF4040]/10 border border-[#FF4040]/20 p-4 rounded-2xl font-semibold text-sm flex items-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ errorMessage }}
                        </div>
                    </form>
                </div>

                <!-- Individual Results Grid (Shows after calculation) -->
                <div v-if="results.length > 0" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div v-for="res in results" :key="res.entry_no"
                        class="bg-white p-6 rounded-[2rem] border border-[#131747]/10 shadow-sm relative overflow-hidden">
                        <div
                            class="absolute top-0 right-0 p-4 font-mono text-[10px] text-[#131747]/20 font-bold uppercase tracking-widest">
                            Entry #{{ res.entry_no }}</div>

                        <h4 class="text-[#131747]/50 text-[10px] font-bold uppercase tracking-widest mb-4">Calculation
                            Result
                        </h4>

                        <div class="space-y-4">
                            <div class="bg-[#131747]/5 p-4 rounded-xl border border-[#131747]/5">
                                <p class="text-xs text-[#131747]/60 font-bold uppercase">Break-Even Price</p>
                                <p class="text-2xl font-mono font-black text-[#131747]">${{ res.break_even_price }}</p>
                            </div>
                            <div class="bg-[#131747] p-4 rounded-xl shadow-lg relative overflow-hidden">
                                <div class="absolute inset-0 bg-gradient-to-br from-[#FF4040]/20 to-transparent"></div>
                                <div class="relative z-10">
                                    <p class="text-xs text-white/60 font-bold uppercase">Target ({{ res.profit_percent
                                    }}%
                                        Margin)</p>
                                    <p class="text-2xl font-mono font-black text-white">${{ res.target_price }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Documentation -->
                <CalculatorHowToUse :title="calculator.how_to_use.title" :steps="calculator.how_to_use.steps" />

                <CalculatorResultsHelp :title="calculator.results_help.title" :items="calculator.results_help.items" />

                <CalculatorTips :tips="calculator.tips" />

                <CalculatorFAQ :faqs="calculator.faqs" />
            </div>
        </div>

        <!-- Premium Popup Result Modal -->
        <Modal :show="results.length > 0" maxWidth="4xl" @close="results = []">
            <div class="bg-white relative overflow-hidden" v-if="results.length > 0">
                <!-- Header -->
                <div class="p-6 border-b border-[#131747]/10 bg-[#131747]/5 flex items-center justify-between">
                    <h3 class="text-xs font-bold text-[#131747] uppercase tracking-widest">Entry-by-Entry Analysis</h3>
                    <button @click="results = []" class="text-[#131747]/40 hover:text-[#FF4040] transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M6 18L18 6M6 6l12 12" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </button>
                </div>

                <!-- Scrollable Content -->
                <div class="p-8 max-h-[70vh] overflow-y-auto space-y-10">
                    <div v-for="(res, index) in results" :key="index" class="group">
                        <!-- Entry Label -->
                        <div class="flex items-center gap-4 mb-4">
                            <span
                                class="flex-none bg-[#131747] text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase">
                                Entry #{{ res.entry_no }}
                            </span>
                            <div class="h-px w-full bg-[#131747]/10"></div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Input Summary (Displays the specific data for this row) -->
                            <div class="bg-[#131747]/[0.02] border border-dashed border-[#131747]/20 rounded-2xl p-5">
                                <p class="text-[10px] font-bold text-[#131747]/40 uppercase mb-3 tracking-wider">Input
                                    Details
                                </p>
                                <div class="space-y-2">
                                    <div class="flex justify-between text-sm">
                                        <span class="text-[#131747]/60">Total Expense:</span>
                                        <span class="font-bold text-[#131747]">${{ res.expense }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-[#131747]/60">Target Volume:</span>
                                        <span class="font-bold text-[#131747]">{{ res.units }} Units</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Break Even Result -->
                            <div class="bg-white border border-[#131747]/10 rounded-2xl p-5 shadow-sm">
                                <p class="text-[10px] font-bold text-[#131747]/60 uppercase mb-1 tracking-wider">
                                    Break-Even
                                    Price</p>
                                <p class="text-2xl font-black text-[#131747] font-mono">
                                    ${{ res.break_even_price }}
                                    <span class="text-xs text-[#131747]/40 ml-1">/unit</span>
                                </p>
                                <div class="flex items-center gap-1.5 mt-2">
                                    <div class="w-1.5 h-1.5 rounded-full bg-orange-400"></div>
                                    <p class="text-[10px] font-bold text-[#131747]/50 uppercase">Zero profit threshold
                                    </p>
                                </div>
                            </div>

                            <!-- Individual Target Result (Using res.profit_percent) -->
                            <div class="bg-[#131747] rounded-2xl p-5 shadow-xl relative overflow-hidden group/card">
                                <div
                                    class="absolute inset-0 bg-gradient-to-br from-[#FF4040]/30 to-transparent transition-opacity group-hover/card:opacity-100 opacity-60">
                                </div>
                                <div class="relative z-10">
                                    <p class="text-[10px] font-bold text-[#FF4040] uppercase mb-1 tracking-wider">
                                        Target Price ({{ res.profit_percent }}%)
                                    </p>
                                    <p class="text-2xl font-black text-white font-mono">
                                        ${{ res.target_price }}
                                        <span class="text-xs text-white/40 ml-1">/unit</span>
                                    </p>
                                    <div class="flex items-center gap-1.5 mt-2">
                                        <div class="w-1.5 h-1.5 rounded-full bg-[#FF4040]"></div>
                                        <p class="text-[10px] font-bold text-white/50 uppercase">Optimized for margin
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="p-6 bg-gray-50 border-t border-[#131747]/10 flex justify-end items-center">
                    <button @click="results = []"
                        class="px-10 py-3 bg-[#131747] text-white rounded-xl font-bold text-sm hover:bg-[#FF4040] transition-all active:scale-95 shadow-lg shadow-[#131747]/10">
                        Close Analysis
                    </button>
                </div>
            </div>
        </Modal>

    </AuthenticatedLayout>
</template>
