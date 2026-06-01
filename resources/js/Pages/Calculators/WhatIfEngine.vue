<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { useCalculator } from '@/Composable/useCalculator';
import CalculatorHero from '@/Components/Calculators/CalculatorHero.vue';
import CalculatorHowToUse from '@/Components/Calculators/CalculatorHowToUse.vue';
import CalculatorResultsHelp from '@/Components/Calculators/CalculatorResultsHelp.vue';
import CalculatorTips from '@/Components/Calculators/CalculatorTips.vue';
import CalculatorFAQ from '@/Components/Calculators/CalculatorFAQ.vue';

const calculator = useCalculator('what_if_engine');

const baseRevenue = ref(100000);
const baseCosts = ref(65000);

// Sliders representing percentage shifts (-50% to +50%)
const revenueShift = ref(0);
const costShift = ref(0);

// Realtime Computed Logic
const simulatedRevenue = computed(() => {
    return baseRevenue.value * (1 + (revenueShift.value / 100));
});

const simulatedCosts = computed(() => {
    return baseCosts.value * (1 + (costShift.value / 100));
});

const simulatedProfit = computed(() => {
    return simulatedRevenue.value - simulatedCosts.value;
});

const simulatedMarginText = computed(() => {
    if (simulatedRevenue.value === 0) return "0.0%";
    const margin = (simulatedProfit.value / simulatedRevenue.value) * 100;
    return margin.toFixed(1) + '%';
});

// Summary Recommendations based on simulation
const summaryRecommendation = computed(() => {
    const margin = (simulatedProfit.value / simulatedRevenue.value) * 100;
    if (simulatedProfit.value < 0) {
        return "WARNING: This scenario results in a loss. Stop dropping revenue and immediately focus on cutting costs by at least " + Math.abs(costShift.value) + "%.";
    }
    if (margin < 10) {
        return "CAUTION: Margins are under 10%. This scenario is barely profitable and very vulnerable to market shifts. Consider holding operations or optimizing pricing.";
    }
    if (margin > 30) {
        return "GREAT: This scenario targets high profitability (+30%). We recommend executing this growth strategy. Re-invest the extra money back into marketing.";
    }
    return "STABLE: Healthy profitability. This is a safe, maintainable scenario for the current quarter.";
});
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
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
                        <!-- Inputs & Sliders (Left 7 Cols) -->
                        <div class="lg:col-span-7 space-y-8">
                            
                            <!-- Base State -->
                            <div class="bg-[#131747]/5 p-8 rounded-2xl border border-[#131747]/10">
                                <h4 class="text-xs font-bold text-[#131747]/50 uppercase tracking-[0.2em] border-b border-[#131747]/10 pb-3 mb-5">Your Current Numbers</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-xs font-bold text-[#131747] uppercase tracking-[0.1em] mb-2">Base Monthly Revenue ($)</label>
                                        <input type="number" v-model="baseRevenue" class="w-full bg-white border border-[#131747]/10 rounded-xl py-4 px-4 text-[#131747] font-bold focus:ring-2 focus:ring-[#FF4040] focus:border-[#FF4040] shadow-sm font-mono placeholder-[#131747]/30 transition-colors">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-[#131747] uppercase tracking-[0.1em] mb-2">Base Cost ($)</label>
                                        <input type="number" v-model="baseCosts" class="w-full bg-white border border-[#131747]/10 rounded-xl py-4 px-4 text-[#131747] font-bold focus:ring-2 focus:ring-[#FF4040] focus:border-[#FF4040] shadow-sm font-mono placeholder-[#131747]/30 transition-colors">
                                    </div>
                                </div>
                            </div>

                            <!-- "What If" Sliders -->
                            <div class="space-y-6 pt-4">
                                <h4 class="text-sm font-bold text-[#131747]">Change the Scenario</h4>
                                
                                <div class="bg-white p-6 rounded-2xl border border-[#131747]/10 shadow-sm">
                                    <div class="flex justify-between items-center mb-6">
                                        <label class="text-sm font-bold text-[#131747]">"What if Revenue shifts by..."</label>
                                        <span :class="revenueShift >= 0 ? 'text-[#131747] bg-[#131747]/10' : 'text-[#FF4040] bg-[#FF4040]/10'" class="px-3 py-1 rounded-md font-mono font-bold text-sm border" :style="revenueShift >= 0 ? 'border-color: rgba(19,23,71,0.2)' : 'border-color: rgba(255,64,64,0.3)'">
                                            {{ revenueShift > 0 ? '+' : '' }}{{ revenueShift }}%
                                        </span>
                                    </div>
                                    <input type="range" v-model="revenueShift" min="-50" max="100" class="w-full h-2 bg-[#131747]/10 rounded-lg appearance-none cursor-pointer accent-[#FF4040]">
                                    <div class="flex justify-between text-[10px] text-[#131747]/40 mt-3 font-mono uppercase font-bold tracking-wider">
                                        <span>Crisis (-50%)</span>
                                        <span>Normal (0)</span>
                                        <span>Surge (+100%)</span>
                                    </div>
                                </div>

                                <div class="bg-white p-6 rounded-2xl border border-[#131747]/10 shadow-sm">
                                    <div class="flex justify-between items-center mb-6">
                                        <label class="text-sm font-bold text-[#131747]">"What if Costs shift by..."</label>
                                        <span :class="costShift <= 0 ? 'text-[#131747] bg-[#131747]/10' : 'text-[#FF4040] bg-[#FF4040]/10'" class="px-3 py-1 rounded-md font-mono font-bold text-sm border" :style="costShift <= 0 ? 'border-color: rgba(19,23,71,0.2)' : 'border-color: rgba(255,64,64,0.3)'">
                                            {{ costShift > 0 ? '+' : '' }}{{ costShift }}%
                                        </span>
                                    </div>
                                    <input type="range" v-model="costShift" min="-50" max="100" class="w-full h-2 bg-[#131747]/10 rounded-lg appearance-none cursor-pointer accent-[#131747]">
                                    <div class="flex justify-between text-[10px] text-[#131747]/40 mt-3 font-mono uppercase font-bold tracking-wider">
                                        <span>Cost Cut (-50%)</span>
                                        <span>Normal (0)</span>
                                        <span>Spike (+100%)</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- Realtime Simulated Result Board (Right 5 Cols) -->
                        <div class="lg:col-span-5 relative">
                            
                            <!-- Dynamic Analytics Output Container -->
                            <div class="sticky top-24 bg-[#131747] rounded-[2rem] shadow-[0_20px_60px_-15px_rgba(19,23,71,0.6)] overflow-hidden border border-[#131747]">
                                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(255,64,64,0.15),_transparent_50%)] z-0"></div>
                                <div class="p-6 border-b border-white/10 bg-black/10 relative z-10 flex justify-between items-center">
                                    <span class="text-xs font-bold text-white/50 uppercase tracking-[0.2em]">Simulation Results</span>
                                </div>
                                
                                <div class="p-8 space-y-8 relative z-10">
                                    <div class="grid grid-cols-2 gap-6 pb-8 border-b border-white/10">
                                        <div>
                                            <p class="text-[10px] text-white/40 font-bold uppercase tracking-[0.1em] mb-2">Simulated Revenue</p>
                                            <p class="text-2xl font-mono font-bold text-white break-words">${{ simulatedRevenue.toFixed(0) }}</p>
                                        </div>
                                        <div>
                                            <p class="text-[10px] text-white/40 font-bold uppercase tracking-[0.1em] mb-2">Simulated Costs</p>
                                            <p class="text-2xl font-mono font-bold text-white/70 break-words">${{ simulatedCosts.toFixed(0) }}</p>
                                        </div>
                                    </div>

                                    <div>
                                        <p class="text-xs text-white/40 font-bold uppercase tracking-[0.2em] mb-3">Simulated Net Profit</p>
                                        <p :class="simulatedProfit >= 0 ? 'text-white' : 'text-[#FF4040]'" class="text-5xl lg:text-6xl font-mono font-extrabold tracking-tight break-words drop-shadow-sm">
                                            ${{ Math.abs(simulatedProfit).toFixed(0) }}
                                        </p>
                                        <p v-if="simulatedProfit < 0" class="text-xs text-[#FF4040] uppercase tracking-widest mt-2 font-bold">Projected Loss</p>
                                    </div>
                                    
                                    <div>
                                        <p class="text-xs text-white/40 font-bold uppercase tracking-[0.2em] mb-3">Profit Margin</p>
                                        <span :class="simulatedProfit >= 0 ? 'bg-white/10 text-white border-white/20' : 'bg-[#FF4040]/20 text-[#FF4040] border-[#FF4040]/30'" class="inline-block px-4 py-1.5 font-mono font-bold border rounded-lg text-lg">
                                            {{ simulatedMarginText }}
                                        </span>
                                    </div>
                                </div>
                                
                                <!-- Summary Recommendation Block -->
                                <div class="bg-white/5 border-t border-white/10 p-8 relative z-10">
                                    <h4 :class="simulatedProfit >= 0 ? 'text-white/70' : 'text-[#FF4040]'" class="text-[10px] font-bold uppercase tracking-[0.2em] flex items-center gap-2 mb-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                                        Summary
                                    </h4>
                                    <p class="text-sm text-white/90 leading-relaxed font-medium">
                                        {{ summaryRecommendation }}
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

                <CalculatorHowToUse :title="calculator.how_to_use.title" :steps="calculator.how_to_use.steps" />

                <CalculatorResultsHelp :title="calculator.results_help.title" :items="calculator.results_help.items" />

                <CalculatorTips :tips="calculator.tips" />

                <CalculatorFAQ :faqs="calculator.faqs" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
