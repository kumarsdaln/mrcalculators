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
import CalculatorResultsHelp from '@/Components/Calculators/CalculatorResultsHelp.vue';
import CalculatorTips from '@/Components/Calculators/CalculatorTips.vue';
import CalculatorFAQ from '@/Components/Calculators/CalculatorFAQ.vue';

const calculator = useCalculator('ltv_cac_ratio');

const form = ref({
    marketing_spend: '',
    new_customers: '',
    avg_revenue: '',
    customer_lifetime: ''
});

const result = ref(null);
const errorMessage = ref('');
const loading = ref(false);

const chartOptions = ref({
    chart: { type: 'radialBar', offsetY: -20, fontFamily: 'sans-serif' },
    colors: ['#131747'],
    plotOptions: {
        radialBar: {
            startAngle: -135,
            endAngle: 135,
            hollow: { size: '60%' },
            dataLabels: {
                name: { fontSize: '14px', color: 'rgba(19,23,71,0.5)', offsetY: 40 },
                value: {
                    offsetY: -10,
                    fontSize: '48px',
                    fontWeight: 800,
                    color: '#131747',
                    formatter: function (val) {
                        return val + "x";
                    }
                }
            }
        }
    },
    fill: {
        type: 'solid'
    },
    stroke: { lineCap: 'round' },
    labels: ['LTV to CAC Ratio'],
});

const series = ref([0]); // Default 0

const getHealthStatus = (ratio) => {
    if (ratio < 1) return { text: 'Losing Money on Marketing', class: 'text-[#FF4040] bg-[#FF4040]/10 border-[#FF4040]/30' };
    if (ratio >= 1 && ratio < 3) return { text: 'Barely Profitable (Warning)', class: 'text-amber-600 bg-amber-500/10 border-amber-500/30' };
    if (ratio >= 3 && ratio <= 5) return { text: 'Perfect Balance (Great!)', class: 'text-white bg-[#131747] border-[#131747]' };
    return { text: 'High LTV (Spend More on Ads)', class: 'text-[#131747] bg-[#131747]/10 border-[#131747]/30' };
}

const calculate = async () => {
    errorMessage.value = '';
    result.value = null;
    loading.value = true;
    try {
        const response = await axios.post(route('api.calculator.ltv-cac-ratio'), form.value);
        if (response.data.status === 'success') {
            result.value = {
                cac: response.data.cac,
                ltv: response.data.ltv,
                ratio: response.data.ratio,
                health: getHealthStatus(parseFloat(response.data.ratio))
            };
            
            // Map ratio to gauge 0-100% (capping visual at 6x ratio for the gauge graph)
            let visualRatio = parseFloat(response.data.ratio);
            if (visualRatio > 6) visualRatio = 6;
            
            // Adjust plot colors dynamically based on health
            let color = '#FF4040'; // Red
            if (visualRatio >= 3) color = '#131747'; // Brand Blue
            else if (visualRatio >= 1) color = '#f59e0b'; // Yellow
            
            chartOptions.value = {
                ...chartOptions.value,
                colors: [color]
            };

            series.value = [visualRatio];

        } else {
            errorMessage.value = response.data.error || 'Check your inputs.';
        }
    } catch (e) {
        if (e.response && e.response.data && e.response.data.message) {
            errorMessage.value = e.response.data.message;
        } else {
            errorMessage.value = 'An error occurred while calculating.';
        }
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
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                </Link>
                <div class="flex items-center gap-3">
                    <h2 class="font-bold text-2xl text-[#131747] leading-tight">{{calculator.title}}</h2>
                </div>
            </div>
        </template>
        <CalculatorHero :calculator="calculator" />
        <div class="py-12 bg-transparent min-h-screen">
            <div class="space-y-8">
        
                <div class="bg-white p-8 md:p-10 rounded-[2rem] shadow-lg shadow-[#131747]/5 border border-[#131747]/10">
                    <form @submit.prevent="calculate">
                        <div class="mb-6">
                            
                            <!-- Inputs Grid -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                                <div class="space-y-6">
                                    <h4 class="text-xs font-bold text-[#131747]/50 uppercase tracking-[0.2em] border-b border-[#131747]/10 pb-3">Marketing Costs (CAC)</h4>
                                    
                                    <div>
                                        <label class="block text-xs font-bold text-[#131747] mb-2 uppercase tracking-[0.1em]">Total Marketing Spend ($)</label>
                                        <input type="number" step="0.01" v-model="form.marketing_spend" required class="w-full bg-white border border-[#131747]/10 rounded-xl py-4 px-5 text-[#131747] font-bold focus:ring-2 focus:ring-[#FF4040] focus:border-[#FF4040] shadow-sm font-mono placeholder:text-[#131747]/30 transition-colors" placeholder="10000">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-[#131747] mb-2 uppercase tracking-[0.1em]">New Customers Acquired</label>
                                        <input type="number" step="1" v-model="form.new_customers" required class="w-full bg-white border border-[#131747]/10 rounded-xl py-4 px-5 text-[#131747] font-bold focus:ring-2 focus:ring-[#FF4040] focus:border-[#FF4040] shadow-sm font-mono placeholder:text-[#131747]/30 transition-colors" placeholder="250">
                                    </div>
                                </div>

                                <div class="space-y-6">
                                    <h4 class="text-xs font-bold text-[#131747]/50 uppercase tracking-[0.2em] border-b border-[#131747]/10 pb-3">Customer Value (LTV)</h4>
                                    
                                    <div>
                                        <label class="block text-xs font-bold text-[#131747] mb-2 uppercase tracking-[0.1em]">Avg Monthly Revenue Per User ($)</label>
                                        <input type="number" step="0.01" v-model="form.avg_revenue" required class="w-full bg-white border border-[#131747]/10 rounded-xl py-4 px-5 text-[#131747] font-bold focus:ring-2 focus:ring-[#FF4040] focus:border-[#FF4040] shadow-sm font-mono placeholder:text-[#131747]/30 transition-colors" placeholder="50">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-[#131747] mb-2 uppercase tracking-[0.1em]">Avg Time User Stays (Months)</label>
                                        <input type="number" step="0.1" v-model="form.customer_lifetime" required class="w-full bg-white border border-[#131747]/10 rounded-xl py-4 px-5 text-[#131747] font-bold focus:ring-2 focus:ring-[#FF4040] focus:border-[#FF4040] shadow-sm font-mono placeholder:text-[#131747]/30 transition-colors" placeholder="12">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end mb-8">
                            <button type="submit" :disabled="loading" class="w-full md:w-auto inline-flex items-center justify-center px-8 py-5 text-sm font-bold uppercase tracking-[0.15em] text-white transition-all duration-300 bg-[#131747] border-2 border-[#131747] rounded-2xl hover:bg-[#FF4040] hover:border-[#FF4040] hover:shadow-[0_10px_20px_-10px_rgba(255,64,64,0.5)] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#FF4040] disabled:opacity-50 disabled:hover:bg-[#131747] disabled:hover:border-[#131747]">
                                {{ loading ? 'Calculating...' : 'Calculate Ratio' }}
                            </button>
                        </div>

                        <div v-if="errorMessage" class="flex items-center gap-3 text-[#FF4040] bg-[#FF4040]/10 border border-[#FF4040]/20 p-4 rounded-2xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                            <span class="font-semibold text-sm">{{ errorMessage }}</span>
                        </div>
                    </form>
                </div>

                <CalculatorHowToUse :title="calculator.how_to_use.title" :steps="calculator.how_to_use.steps" />

                <CalculatorResultsHelp :title="calculator.results_help.title" :items="calculator.results_help.items" />

                <CalculatorTips :tips="calculator.tips" />

                <CalculatorFAQ :faqs="calculator.faqs" />

            </div>
        </div>

        <!-- Premium Popup Result Modal -->
        <Modal :show="result !== null" maxWidth="4xl" @close="result = null">
            <div class="bg-white relative overflow-hidden" v-if="result !== null">
                <div class="p-6 md:px-10 md:py-6 relative z-10 flex items-center justify-between border-b border-[#131747]/10 bg-[#131747]/5">
                    <p class="text-xs font-bold text-[#131747] uppercase tracking-[0.2em] flex items-center gap-2">
                        <svg class="w-4 h-4 text-[#FF4040]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        Results
                    </p>
                    <button type="button" @click="result = null" class="text-[#131747]/40 hover:text-[#FF4040] transition-colors rounded-full p-1 border border-transparent hover:border-[#FF4040]/20 bg-transparent hover:bg-[#FF4040]/10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                <div class="p-8 md:p-10 relative z-10">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                        
                        <div class="col-span-1 border-r border-[#131747]/10 pr-0 md:pr-8 flex flex-col justify-center space-y-8">
                            <div>
                                <p class="text-[10px] text-[#131747]/50 font-bold uppercase tracking-[0.2em] mb-2">Cost to Acquire (CAC)</p>
                                <p class="text-4xl font-extrabold text-[#131747] font-mono tracking-tight drop-shadow-sm">${{ result.cac }}</p>
                            </div>
                            <div class="pt-6 border-t border-[#131747]/10">
                                <p class="text-[10px] text-[#131747]/50 font-bold uppercase tracking-[0.2em] mb-2">Customer Value (LTV)</p>
                                <p class="text-4xl font-extrabold text-[#131747] font-mono tracking-tight drop-shadow-sm">${{ result.ltv }}</p>
                            </div>
                            <div :class="['px-4 py-3 rounded-xl border text-xs font-bold uppercase tracking-[0.1em] text-center mt-6 shadow-sm', result.health.class]">
                                {{ result.health.text }}
                            </div>
                        </div>

                        <div class="col-span-2 flex flex-col justify-center items-center h-full">
                            <div class="relative w-full max-w-sm">
                                <VueApexCharts type="radialBar" height="350" :options="chartOptions" :series="series"></VueApexCharts>
                            </div>
                        </div>

                    </div>
                </div>
                
                <div class="p-6 relative z-10 bg-[#131747]/[0.02] border-t border-[#131747]/10 flex justify-end">
                    <button @click="result = null" class="px-8 py-3 rounded-xl bg-[#131747] hover:bg-[#FF4040] text-white font-bold text-sm transition-colors shadow-sm focus:ring-2 focus:ring-offset-2 focus:ring-[#FF4040]">Close</button>
                </div>
            </div>
        </Modal>

    </AuthenticatedLayout>
</template>
