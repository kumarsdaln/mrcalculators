<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Modal from '@/Components/Modal.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import axios from 'axios';

const form = ref({
    yearly_sale: ''
});

const result = ref(null);
const errorMessage = ref('');
const loading = ref(false);

const calculate = async () => {
    errorMessage.value = '';
    result.value = null;
    loading.value = true;
    try {
        const response = await axios.post(route('api.calculator.monthly-sales-goal'), form.value);
        if (response.data.status === 'success') {
            result.value = response.data.monthly_sale;
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
    <Head title="Monthly Sales Goal" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center gap-4">
                <Link :href="route('dashboard')" class="text-[#131747]/60 hover:text-[#FF4040] transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                </Link>
                <h2 class="font-bold text-2xl text-[#131747] leading-tight">Monthly Sales Goal</h2>
            </div>
        </template>

        <div class="py-12 bg-transparent min-h-screen">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-8">
                
                <div class="bg-white p-8 md:p-10 rounded-[2rem] shadow-lg shadow-[#131747]/5 border border-[#131747]/10">
                    <div class="mb-8">
                        <div class="w-14 h-14 bg-[#131747]/5 text-[#131747] rounded-2xl flex items-center justify-center mb-6 border border-[#131747]/10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <h3 class="text-3xl font-extrabold text-[#131747] mb-3">Calculate Your Monthly Sales Target</h3>
                        <p class="text-[#131747]/70 leading-relaxed text-lg">
                            Enter your annual sales target. We'll quickly calculate exactly how much you need to sell each month to stay on track for the year.
                        </p>
                    </div>

                    <hr class="border-[#131747]/10 mb-8" />

                    <form @submit.prevent="calculate" class="space-y-6">
                        <div>
                            <label for="yearly_sale" class="block text-sm font-bold text-[#131747] mb-2 uppercase tracking-[0.1em]">
                                Annual Target ($)
                            </label>
                            <input 
                                id="yearly_sale" 
                                type="number" 
                                step="0.01"
                                v-model="form.yearly_sale" 
                                required
                                class="w-full bg-[#131747]/[0.02] border border-[#131747]/20 rounded-2xl py-4 px-5 text-xl text-[#131747] font-bold focus:ring-2 focus:ring-[#FF4040] focus:border-[#FF4040] transition-colors shadow-sm font-mono placeholder:text-[#131747]/30"
                                placeholder="100000.00"
                            >
                        </div>

                        <div v-if="errorMessage" class="flex items-center gap-3 text-[#FF4040] bg-[#FF4040]/10 border border-[#FF4040]/20 p-4 rounded-2xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                            <span class="font-semibold text-sm">{{ errorMessage }}</span>
                        </div>

                        <button 
                            type="submit" 
                            :disabled="loading" 
                            class="w-full inline-flex items-center justify-center px-8 py-5 text-sm font-bold uppercase tracking-[0.15em] text-white transition-all duration-300 bg-[#131747] border-2 border-[#131747] rounded-2xl hover:bg-[#FF4040] hover:border-[#FF4040] hover:shadow-[0_10px_20px_-10px_rgba(255,64,64,0.5)] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#FF4040] disabled:opacity-50 disabled:hover:bg-[#131747] disabled:hover:border-[#131747]"
                        >
                            {{ loading ? 'Calculating...' : 'Calculate Monthly Goal' }}
                        </button>
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
                        <p>This tool takes your big yearly goal and breaks it down into actionable steps. It helps ensure your team knows exactly what they need to hit each month to avoid falling behind.</p>
                        <div class="bg-[#131747]/5 p-5 border border-[#131747]/10 rounded-2xl mt-4">
                            <p class="text-xs font-bold text-[#131747] uppercase tracking-[0.1em] mb-2">Example</p>
                            <p class="font-mono text-sm">
                                "If you want to make $2,500,000 this year, you enter that target. The calculator will show you need to make <strong class="text-[#131747]">$208,333.33</strong> every single month."
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Premium Popup Result Modal -->
        <Modal :show="result !== null" maxWidth="xl" @close="result = null">
            <div class="bg-[#131747] relative overflow-hidden shadow-[0_20px_60px_-15px_rgba(19,23,71,0.6)]">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(255,64,64,0.35),_transparent_50%)]"></div>
                
                <div class="p-8 relative z-10 flex items-center justify-between border-b border-white/10">
                    <p class="text-xs font-bold text-[#FF4040] uppercase tracking-[0.2em] flex items-center gap-2">
                        <span class="h-2 w-2 rounded-full bg-[#FF4040] animate-pulse"></span>
                        Result
                    </p>
                    <button type="button" @click="result = null" class="text-white/50 hover:text-white transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                <div class="p-8 md:p-10 relative z-10 flex flex-col items-center justify-center text-center gap-6">
                    <div>
                        <p class="text-white/80 font-medium text-lg mb-4">Target Monthly Goal</p>
                        <p class="text-5xl lg:text-6xl font-extrabold text-white font-mono tracking-tight drop-shadow-sm break-words break-all">
                            <span class="text-[#FF4040] mr-2">$</span>{{ result }}
                        </p>
                    </div>
                </div>
                
                <div class="p-6 relative z-10 bg-black/10 flex justify-center">
                    <button @click="result = null" class="px-6 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white font-semibold text-sm transition-colors uppercase tracking-widest border border-white/10">Close</button>
                </div>
            </div>
        </Modal>

    </AuthenticatedLayout>
</template>
