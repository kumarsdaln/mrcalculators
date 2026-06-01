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

const calculator = useCalculator('future_sales_forecast');

const months = ref(['', '', '']); // Start with 3 inputs

const result = ref(null);
const errorMessage = ref('');
const loading = ref(false);

const chartOptions = ref({
    chart: { type: 'area', zoom: { enabled: false }, toolbar: { show: false }, fontFamily: 'sans-serif' },
    colors: ['#131747', '#FF4040'],
    dataLabels: { enabled: false },
    stroke: { curve: 'smooth', width: [3, 3], dashArray: [0, 5] },
    title: { text: 'Sales Forecast', align: 'left', style: { fontWeight: 'bold', color: '#131747' } },
    fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.2, opacityTo: 0.05, stops: [0, 100] } },
    grid: { borderColor: 'rgba(19,23,71,0.05)' },
    xaxis: { categories: [], title: { text: 'Months', style: {color: 'rgba(19,23,71,0.5)'} }, labels: { style: { colors: 'rgba(19,23,71,0.5)' } } },
    yaxis: { title: { text: 'Sales ($)', style: {color: 'rgba(19,23,71,0.5)'} }, labels: { formatter: (val) => '$' + val.toFixed(0), style: { colors: 'rgba(19,23,71,0.5)' } } }
});

const series = ref([]);

const addMonth = () => {
    months.value.push('');
};

const removeMonth = (index) => {
    if(months.value.length > 1) {
        months.value.splice(index, 1);
    }
}

const calculate = async () => {
    errorMessage.value = '';
    result.value = null;
    loading.value = true;
    
    // Quick parse for validation
    const parsedData = months.value.map(val => parseFloat(val) || 0);

    const payload = {
        month: months.value
    };

    try {
        const response = await axios.post(route('api.calculator.future-sales-forecast'), payload);
        if (response.data.status === 'success') {
            result.value = response.data.forecast_future_sales;
            
            // Build visual projection
            const forecastVal = parseFloat(response.data.forecast_future_sales.replace(/,/g, ''));
            const dataPts = [...parsedData, forecastVal];

            const categories = dataPts.map((_, i) => i === dataPts.length - 1 ? 'Next Month (Forecast)' : `Month ${i+1}`);
            
            // Re-assign chart logic to render safely
            chartOptions.value = {
                ...chartOptions.value,
                xaxis: { ...chartOptions.value.xaxis, categories }
            };

            // Two lines: one solid for history, one dotted mapping ONLY the last two points for trend projection
            const historyLine = dataPts.map((val, i) => i === dataPts.length - 1 ? null : val);
            const forecastLine = dataPts.map((val, i) => i >= dataPts.length - 2 ? val : null);

            series.value = [
                {
                    name: 'Past Sales',
                    data: historyLine
                },
                {
                    name: 'Forecast',
                    data: forecastLine
                }
            ];

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
                <h2 class="font-bold text-2xl text-[#131747] leading-tight">{{calculator.title}}</h2>
            </div>
        </template>
        <CalculatorHero :calculator="calculator" />
        <div class="py-12 bg-transparent min-h-screen">
            <div class="space-y-8">
                <div class="bg-white p-8 md:p-10 rounded-[2rem] shadow-lg shadow-[#131747]/5 border border-[#131747]/10">
                    <form @submit.prevent="calculate">
                        
                        <div>
                            <div class="mb-4 pb-4 border-b border-[#131747]/10">
                                <span class="text-xs font-bold uppercase tracking-[0.1em] text-[#131747]/60">Past Monthly Revenue ($)</span>
                            </div>

                            <div class="space-y-4">
                                <div v-for="(amount, index) in months" :key="index" class="flex items-center gap-4">
                                    <div class="font-mono text-[#131747]/40 font-bold text-sm min-w-[3rem]">
                                        M{{ index + 1 }}
                                    </div>
                                    <div class="w-full md:w-1/2 relative bg-[#131747]/[0.02] rounded-xl border border-[#131747]/10 flex focus-within:ring-2 focus-within:ring-[#FF4040] focus-within:border-[#FF4040] transition-colors overflow-hidden">
                                        <div class="pl-4 flex items-center bg-transparent pointer-events-none">
                                            <span class="text-[#131747]/40 font-mono">$</span>
                                        </div>
                                        <input type="number" step="0.01" v-model="months[index]" required class="w-full bg-transparent border-none py-3 pl-2 pr-4 text-[#131747] font-bold font-mono focus:ring-0 placeholder:text-[#131747]/30" placeholder="0.00">
                                    </div>
                                    <div class="w-auto items-center flex">
                                        <button v-if="months.length > 1" type="button" @click="removeMonth(index)" class="text-[#131747]/40 hover:text-[#FF4040] transition p-2 bg-white border border-[#131747]/10 rounded-xl shadow-sm" title="Remove Month">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 pt-4 border-t border-[#131747]/10">
                                <button type="button" @click="addMonth" class="text-xs font-bold uppercase tracking-[0.1em] text-[#131747] hover:text-[#FF4040] transition flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg> Add Another Month
                                </button>
                            </div>
                        </div>

                        <div class="flex justify-end mb-8">
                            <button type="submit" :disabled="loading" class="w-full md:w-auto inline-flex items-center justify-center px-8 py-5 text-sm font-bold uppercase tracking-[0.15em] text-white transition-all duration-300 bg-[#131747] border-2 border-[#131747] rounded-2xl hover:bg-[#FF4040] hover:border-[#FF4040] hover:shadow-[0_10px_20px_-10px_rgba(255,64,64,0.5)] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#FF4040] disabled:opacity-50 disabled:hover:bg-[#131747]">
                                {{ loading ? 'Gathering Results...' : 'Forecast Sales' }}
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
                        Calculation Results
                    </p>
                    <button type="button" @click="result = null" class="text-[#131747]/40 hover:text-[#FF4040] transition-colors rounded-full p-1 border border-transparent hover:border-[#FF4040]/20 bg-transparent hover:bg-[#FF4040]/10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                <div class="p-8 md:p-10 relative z-10">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                        <div class="lg:col-span-1">
                            <div class="bg-[#131747] shadow-[0_20px_40px_-15px_rgba(19,23,71,0.5)] border border-[#131747] rounded-2xl p-8 h-full flex flex-col justify-center text-center transition duration-300 relative overflow-hidden group">
                                <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_bottom,_rgba(255,64,64,0.25),_transparent_60%)]"></div>
                                <div class="relative z-10">
                                    <p class="text-xs font-bold text-[#FF4040] uppercase tracking-[0.2em] mb-2 flex items-center justify-center gap-2">
                                        <span class="h-2 w-2 rounded-full bg-[#FF4040] animate-pulse"></span>
                                        Forecast
                                    </p>
                                    <p class="text-white/80 font-medium mb-5">Predicted Next Month Sales</p>
                                    <p class="text-4xl md:text-5xl font-extrabold text-white font-mono tracking-tight drop-shadow-sm group-hover:scale-[1.02] transition duration-300 break-words break-all">
                                        <span class="text-[#FF4040] mr-2">$</span>{{ result }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Visualization -->
                        <div class="lg:col-span-2 bg-white border border-[#131747]/10 rounded-2xl p-6 flex items-center justify-center min-h-[300px] shadow-sm">
                            <VueApexCharts class="w-full" type="area" height="300" :options="chartOptions" :series="series"></VueApexCharts>
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
