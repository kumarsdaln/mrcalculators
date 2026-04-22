<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Modal from '@/Components/Modal.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref, nextTick } from 'vue';
import axios from 'axios';
import VueApexCharts from 'vue3-apexcharts';

const months = ref([
    { amount: '', unit: '' },
    { amount: '', unit: '' }
]);

const tpt = ref('');
const result = ref(null);
const errorMessage = ref('');
const loading = ref(false);

const chartOptions = ref({
    chart: { type: 'line', zoom: { enabled: false }, toolbar: { show: false }, fontFamily: 'sans-serif' },
    colors: ['#FF4040', '#131747'],
    dataLabels: { enabled: false },
    stroke: { curve: 'straight', width: 3 },
    title: { text: 'Break-Even Analysis', align: 'left', style: { fontWeight: 'bold', color: '#131747' } },
    grid: { borderColor: 'rgba(19,23,71,0.05)' },
    xaxis: { categories: ['Current Volume', 'Break-Even', 'Target Target'], title: { text: 'Volume Scenarios', style: {color: 'rgba(19,23,71,0.5)'} }, labels: { style: { colors: 'rgba(19,23,71,0.5)' } } },
    yaxis: { title: { text: 'Dollars ($)', style: {color: 'rgba(19,23,71,0.5)'} }, labels: { formatter: (val) => '$' + val.toFixed(0), style: { colors: 'rgba(19,23,71,0.5)' } } }
});

const series = ref([]);

const addMonth = () => {
    months.value.push({ amount: '', unit: '' });
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
    
    // Quick validation
    const outlay = months.value.map(m => parseFloat(m.amount) || 0);
    const units = months.value.map(m => parseFloat(m.unit) || 0);
    const totalOutlay = outlay.reduce((a,b)=>a+b, 0);
    const totalUnits = units.reduce((a,b)=>a+b, 0);

    const payload = {
        month: months.value.map(m => m.amount),
        unit: months.value.map(m => m.unit),
        tpt: tpt.value
    };

    try {
        const response = await axios.post(route('api.calculator.break-even-and-selling-price'), payload);
        if (response.data.status === 'success') {
            result.value = {
                break_even: response.data.break_even_price,
                target: response.data.monthly_sales_target
            };

            // Setup chart projection visually
            // X-axis: 3 instances (Base, Break-Even volume threshold, target)
            // Revenue line vs constant costs line (simplified model for visual aid)
            const bePrice = parseFloat(response.data.break_even_price.replace(/,/g, ''));
            const targetSale = parseFloat(response.data.monthly_sales_target.replace(/,/g, ''));

            series.value = [
                {
                    name: 'Total Costs',
                    data: [totalOutlay, totalOutlay, totalOutlay] // simplified fixed costs
                },
                {
                    name: 'Projected Revenue',
                    // Assuming BE price * units is break even point
                    data: [(bePrice * (totalUnits/2)), (bePrice * totalUnits), targetSale] 
                }
            ];

        } else {
            errorMessage.value = response.data.error || 'Check your inputs. Ensure non-zero units.';
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
    <Head title="Break-Even Calculator" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center gap-4">
                <Link :href="route('dashboard')" class="text-[#131747]/60 hover:text-[#FF4040] transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                </Link>
                <h2 class="font-bold text-2xl text-[#131747] leading-tight">Break-Even Calculator</h2>
            </div>
        </template>

        <div class="py-12 bg-transparent min-h-screen">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-8">
                
                <div class="bg-white p-8 md:p-10 rounded-[2rem] shadow-lg shadow-[#131747]/5 border border-[#131747]/10">
                    <div class="mb-8 max-w-3xl">
                        <div class="w-14 h-14 bg-[#131747]/5 text-[#131747] rounded-2xl flex items-center justify-center mb-6 border border-[#131747]/10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" /></svg>
                        </div>
                        <h3 class="text-3xl font-extrabold text-[#131747] mb-3">Calculate Your Break-Even Price</h3>
                        <p class="text-[#131747]/70 leading-relaxed text-lg">
                            Enter your costs and how many units you plan to sell. We'll show you the exact price you need to charge to break even, and what you should charge to hit your profit goal.
                        </p>
                    </div>

                    <form @submit.prevent="calculate">
                        <div class="bg-white border border-[#131747]/10 rounded-2xl p-6 mb-8 shadow-sm">
                            <div class="hidden md:grid grid-cols-12 gap-4 mb-4 pb-2 border-b border-[#131747]/10">
                                <div class="col-span-1"></div>
                                <div class="col-span-5 text-xs font-bold uppercase tracking-[0.1em] text-[#131747]/60">Total Costs ($)</div>
                                <div class="col-span-5 text-xs font-bold uppercase tracking-[0.1em] text-[#131747]/60">Units to Sell</div>
                                <div class="col-span-1"></div>
                            </div>

                            <div class="space-y-4">
                                <div v-for="(item, index) in months" :key="index" class="flex flex-col md:grid md:grid-cols-12 gap-4 items-center">
                                    <div class="col-span-12 md:col-span-1 font-mono text-[#131747]/40 font-bold self-start md:self-center text-sm">
                                        #{{ index + 1 }}
                                    </div>
                                    <div class="col-span-12 md:col-span-5 w-full">
                                        <input type="number" step="0.01" v-model="item.amount" required class="w-full bg-[#131747]/[0.02] border border-[#131747]/10 rounded-xl py-3 px-4 text-[#131747] font-bold focus:ring-2 focus:ring-[#FF4040] focus:border-[#FF4040] transition-colors font-mono placeholder:text-[#131747]/30" placeholder="0.00">
                                    </div>
                                    <div class="col-span-12 md:col-span-5 w-full">
                                        <input type="number" step="0.01" v-model="item.unit" required class="w-full bg-[#131747]/[0.02] border border-[#131747]/10 rounded-xl py-3 px-4 text-[#131747] font-bold focus:ring-2 focus:ring-[#FF4040] focus:border-[#FF4040] transition-colors font-mono placeholder:text-[#131747]/30" placeholder="0">
                                    </div>
                                    <div class="col-span-12 md:col-span-1 w-full md:w-auto flex justify-end">
                                        <button v-if="months.length > 1" type="button" @click="removeMonth(index)" class="text-[#131747]/40 hover:text-[#FF4040] transition p-2 bg-white border border-[#131747]/10 rounded-xl shadow-sm" title="Remove Row">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-4 pt-4 border-t border-[#131747]/10">
                                <button type="button" @click="addMonth" class="text-xs font-bold uppercase tracking-[0.1em] text-[#131747] hover:text-[#FF4040] transition flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg> Add Row
                                </button>
                            </div>
                        </div>

                        <!-- Target Constraints -->
                        <div class="flex flex-col md:flex-row gap-6 items-end mb-8">
                            <div class="w-full md:w-1/2">
                                <label class="block text-sm font-bold text-[#131747] mb-2 uppercase tracking-[0.1em]">
                                    Desired Profit Margin (%)
                                </label>
                                <input type="number" step="0.01" v-model="tpt" required class="w-full bg-[#131747]/[0.02] border border-[#131747]/20 rounded-2xl py-4 px-5 text-xl font-bold text-[#131747] focus:ring-2 focus:ring-[#FF4040] focus:border-[#FF4040] font-mono shadow-sm transition-colors placeholder:text-[#131747]/30" placeholder="15.5">
                            </div>
                            <div class="w-full md:w-1/2">
                                <button type="submit" :disabled="loading" class="w-full inline-flex items-center justify-center px-8 py-5 text-sm font-bold uppercase tracking-[0.15em] text-white transition-all duration-300 bg-[#131747] border-2 border-[#131747] rounded-2xl hover:bg-[#FF4040] hover:border-[#FF4040] hover:shadow-[0_10px_20px_-10px_rgba(255,64,64,0.5)] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#FF4040] disabled:opacity-50 disabled:hover:bg-[#131747]">
                                    {{ loading ? 'Calculating...' : 'Calculate Break-Even Price' }}
                                </button>
                            </div>
                        </div>
                        
                        <div v-if="errorMessage" class="flex items-center gap-3 text-[#FF4040] bg-[#FF4040]/10 border border-[#FF4040]/20 p-4 rounded-2xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                            <span class="font-semibold text-sm">{{ errorMessage }}</span>
                        </div>
                    </form>
                </div>

                <!-- Documentation Module -->
                <div class="bg-white border border-[#131747]/10 p-8 rounded-[2rem] mt-8 shadow-sm">
                    <h4 class="text-lg font-bold text-[#131747] mb-6 flex items-center gap-3">
                        <span class="bg-[#131747]/5 p-2 rounded-lg text-[#131747]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </span>
                        How It Works
                    </h4>
                    <div class="space-y-4 text-[#131747]/70 text-sm leading-relaxed">
                        <p>This tool helps you figure out exactly how much you need to charge for your product or service so you don't lose money. It also takes your profit goal and tells you the exact price you should sell at to hit that goal.</p>
                        <div class="bg-[#131747]/5 p-5 border border-[#131747]/10 rounded-2xl mt-4">
                            <p class="text-xs font-bold text-[#131747] uppercase tracking-[0.1em] mb-2">Example</p>
                            <p class="font-mono text-sm">
                                "You spent $5,000 this month, and you made 100 units of your product. You want a 20% profit margin.<br/><br/>
                                The tool will show your <strong class="text-[#131747]">Break-Even Price is $50.00</strong>. With your 20% goal, your <strong class="text-[#131747]">Target Selling Price is $62.50</strong>."
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Premium Popup Result Modal -->
        <Modal :show="result !== null" maxWidth="4xl" @close="result = null">
            <div class="bg-white relative overflow-hidden" v-if="result !== null">
                <div class="p-6 md:px-10 md:py-6 relative z-10 flex items-center justify-between border-b border-[#131747]/10 bg-[#131747]/5">
                    <p class="text-xs font-bold text-[#131747] uppercase tracking-[0.2em] flex items-center gap-2">
                        <svg class="w-4 h-4 text-[#FF4040]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        Result
                    </p>
                    <button type="button" @click="result = null" class="text-[#131747]/40 hover:text-[#FF4040] transition-colors rounded-full p-1 border border-transparent hover:border-[#FF4040]/20 bg-transparent hover:bg-[#FF4040]/10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                <div class="p-8 md:p-10 relative z-10">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                        <!-- Data Blocks -->
                        <div class="space-y-6">
                            <div class="bg-[#131747]/5 border border-[#131747]/10 rounded-2xl p-8">
                                <p class="text-xs font-bold text-[#131747]/60 uppercase tracking-[0.2em] mb-2">Base Minimum</p>
                                <p class="text-[#131747] font-semibold text-lg mb-3">Required Break-Even Price</p>
                                <p class="text-4xl lg:text-5xl font-extrabold text-[#131747] font-mono tracking-tight break-words break-all">
                                    <span class="text-[#131747]/40 mr-1">$</span>{{ result.break_even }}
                                </p>
                            </div>
                            <div class="bg-[#131747] border border-[#131747] rounded-2xl p-8 shadow-[0_20px_40px_-15px_rgba(19,23,71,0.5)] relative overflow-hidden">
                                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(255,64,64,0.3),_transparent_60%)]"></div>
                                <div class="relative z-10">
                                    <p class="text-xs font-bold text-[#FF4040] uppercase tracking-[0.2em] mb-2 flex items-center gap-2">
                                        <span class="h-2 w-2 rounded-full bg-[#FF4040] animate-pulse"></span>
                                        Goal Hit
                                    </p>
                                    <p class="text-white/90 font-semibold text-lg mb-3">Target Selling Price</p>
                                    <p class="text-4xl lg:text-5xl font-extrabold text-white font-mono tracking-tight break-words break-all">
                                        <span class="text-[#FF4040] mr-2">$</span>{{ result.target }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Visualization -->
                        <div class="bg-white border border-[#131747]/10 rounded-2xl p-6 flex flex-col justify-center min-h-[300px] shadow-sm">
                            <VueApexCharts class="w-full" type="line" height="300" :options="chartOptions" :series="series"></VueApexCharts>
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
