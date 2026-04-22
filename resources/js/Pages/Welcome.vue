<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    plans: {
        type: Array,
        default: () => [],
    },
});
</script>

<template>
    <Head title="MR Calculators | Financial Intelligence, Made Actionable" />

    <div class="min-h-screen bg-[linear-gradient(180deg,#ffffff_0%,rgba(19,23,71,0.04)_100%)] text-[#131747] font-sans selection:bg-[#FF4040] selection:text-white">
        <!-- Navigation -->
        <nav class="sticky top-0 z-50 border-b border-[#131747]/10 bg-white/80 backdrop-blur-xl">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-20 gap-4">
                    <div class="flex items-center gap-2">
                        <ApplicationLogo class="max-h-12 w-12" />
                    </div>
                    <div v-if="canLogin" class="flex gap-4 items-center">
                        <Link v-if="$page.props.auth.user" :href="route('dashboard')" class="inline-flex items-center justify-center rounded-2xl border border-[#131747] bg-[#131747] px-6 py-2.5 text-sm font-semibold text-white transition hover:border-[#FF4040] hover:bg-[#FF4040]">
                            Access Control Panel
                        </Link>
                        <template v-else>
                            <Link :href="route('login')" class="text-sm font-semibold text-[#131747]/70 hover:text-[#FF4040] transition">
                                Login
                            </Link>
                            <Link v-if="canRegister" :href="route('register')" class="inline-flex items-center justify-center rounded-2xl border border-[#131747] bg-[#131747] px-6 py-2.5 text-sm font-semibold text-white shadow-xl shadow-[#131747]/15 transition hover:border-[#FF4040] hover:bg-[#FF4040] hover:shadow-[#FF4040]/20 hover:-translate-y-0.5">
                                Register
                            </Link>
                        </template>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="relative overflow-hidden py-24 md:py-32">
            <div class="absolute top-0 right-0 -m-32 w-[600px] h-[600px] bg-[#FF4040]/10 rounded-full blur-[120px] pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 -m-32 w-[600px] h-[600px] bg-[#131747]/5 rounded-full blur-[120px] pointer-events-none"></div>
            
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                    <div class="space-y-8">
                        <div class="inline-flex items-center gap-2 rounded-full border border-[#FF4040]/20 bg-[#FF4040]/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.24em] text-[#FF4040]">
                            <span class="h-2 w-2 rounded-full bg-[#FF4040] animate-pulse"></span>
                            Sales & Profit Forecast Calculator
                        </div>
                        <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight leading-tight text-[#131747]">
                            Stop Guessing. <br/><span class="text-transparent bg-clip-text bg-gradient-to-r from-[#131747] to-[#FF4040]">Start Growing.</span>
                        </h1>
                        <p class="text-lg md:text-xl text-[#131747]/70 max-w-lg leading-relaxed">
                            As a business owner, every decision you make has a financial consequence. But how many of those decisions are based on gut feeling rather than real numbers? That's where most businesses fall behind — and where yours doesn't have to.
                        </p>
                        <div class="flex items-center gap-4 pt-4">
                            <Link v-if="$page.props.auth.user" :href="route('dashboard')" class="inline-flex items-center justify-center rounded-2xl border border-[#131747] bg-[#131747] px-8 py-4 text-sm font-semibold text-white shadow-xl shadow-[#131747]/15 transition hover:-translate-y-1 hover:border-[#FF4040] hover:bg-[#FF4040]">
                                Access Command Center
                            </Link>
                            <Link v-else :href="route('register')" class="inline-flex items-center justify-center rounded-2xl border border-[#FF4040] bg-[#FF4040] px-8 py-4 text-sm font-bold text-white shadow-xl shadow-[#FF4040]/20 transition hover:-translate-y-1 hover:bg-[#e23535] group">
                                Start forecasting. Start growing.
                                <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </Link>
                        </div>
                        <div class="flex items-center gap-6 text-sm text-[#131747]/60 font-medium pt-4">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-[#FF4040]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Simple like messaging
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-[#131747]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Enterprise-grade power
                            </div>
                        </div>
                    </div>
                    
                    <div class="relative hidden lg:block">
                        <div class="absolute inset-0 bg-gradient-to-tr from-[#131747]/20 to-[#FF4040]/20 blur-3xl opacity-50 -z-10 rounded-[3rem]"></div>
                        <div class="rounded-[2.5rem] border border-[#131747] bg-[#131747] p-8 shadow-[0_28px_100px_-40px_rgba(19,23,71,0.85)] relative overflow-hidden group">
                           <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(255,64,64,0.15),_transparent_40%),linear-gradient(135deg,_rgba(255,255,255,0.02),_transparent_60%)]"></div>
                           
                           <!-- Faux UI -->
                           <div class="relative z-10">
                               <div class="flex items-center justify-between border-b border-white/10 pb-5 mb-8">
                                   <div class="flex flex-col">
                                       <span class="text-[10px] font-bold text-[#FF4040] uppercase tracking-[0.24em]">Intelligence Stream</span>
                                       <span class="text-white text-sm font-semibold mt-1">MR Calculators Core</span>
                                   </div>
                                   <span class="flex h-3 w-3">
                                       <span class="absolute inline-flex h-3 w-3 animate-ping rounded-full bg-[#FF4040] opacity-75"></span>
                                       <span class="relative inline-flex h-3 w-3 rounded-full bg-[#FF4040]"></span>
                                   </span>
                               </div>

                               <div class="space-y-4">
                                   <!-- Alert Card -->
                                   <div class="rounded-2xl border border-white/10 bg-white/5 p-5 backdrop-blur-md transform transition-all duration-300 hover:-translate-y-1 hover:border-white/20">
                                        <div class="flex items-start gap-4">
                                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#FF4040]/20 text-[#FF4040]">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-white">Risk Detection Mode</p>
                                                <p class="mt-2 text-xs leading-relaxed text-white/70">Based on recent volume trends, Q4 targets face a 12% shortfall. Recommend lowering Break-Even margin by cutting fixed costs.</p>
                                                <button class="mt-4 rounded-xl border border-white/15 bg-white/10 px-4 py-2 text-[11px] font-semibold text-white uppercase tracking-[0.1em] hover:bg-white/20 transition">Simulate Vector</button>
                                            </div>
                                        </div>
                                   </div>
                                    <!-- Positive Card -->
                                    <div class="rounded-2xl border border-white/10 bg-white/5 p-5 backdrop-blur-md transform transition-all duration-300 hover:-translate-y-1 hover:border-white/20">
                                        <div class="flex items-start gap-4">
                                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white/10 text-white">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-white">Sales Target Mapping</p>
                                                <p class="mt-1 text-xs text-white/60">Sales trend extrapolation complete. Next month's target safely locked at $142,500.</p>
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

        <!-- The Problem & Solution -->
        <div class="py-24 border-y border-[#131747]/10 bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-4xl mx-auto mb-20 space-y-4">
                    <span class="text-[#FF4040] font-bold tracking-[0.2em] text-xs uppercase rounded-full bg-[#FF4040]/10 px-4 py-1.5 inline-block">The Game Changer</span>
                    <h2 class="text-4xl font-extrabold text-[#131747]">Imagine knowing exactly where your sales and profits are headed — before you get there.</h2>
                    <p class="text-lg text-[#131747]/70 leading-relaxed max-w-3xl mx-auto">Built specifically for business owners who are serious about growth. Take the guesswork out of your financial planning and eliminate end-of-month panic.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div class="rounded-[2rem] border border-[#131747]/10 bg-[linear-gradient(180deg,#ffffff_0%,rgba(19,23,71,0.02)_100%)] p-8 text-center transition duration-300 hover:-translate-y-2 hover:shadow-xl hover:shadow-[#131747]/5">
                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-[#131747] text-white shadow-lg mb-8">
                            <span class="font-bold text-xl tracking-widest">01</span>
                        </div>
                        <h3 class="text-xl font-bold text-[#131747] mb-4">Revenue Predictability</h3>
                        <p class="text-[#131747]/70 text-sm leading-relaxed">How much revenue you can realistically expect next month, next quarter, or next year.</p>
                    </div>
                    <!-- Feature 2 -->
                    <div class="rounded-[2rem] border border-[#131747]/10 bg-[linear-gradient(180deg,#ffffff_0%,rgba(19,23,71,0.02)_100%)] p-8 text-center transition duration-300 hover:-translate-y-2 hover:shadow-xl hover:shadow-[#131747]/5">
                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-[#FF4040] text-white shadow-lg shadow-[#FF4040]/30 mb-8">
                             <span class="font-bold text-xl tracking-widest">02</span>
                        </div>
                        <h3 class="text-xl font-bold text-[#131747] mb-4">Strategy Validation</h3>
                        <p class="text-[#131747]/70 text-sm leading-relaxed">Whether your current strategy will actually deliver the profits you need.</p>
                    </div>
                    <!-- Feature 3 -->
                    <div class="rounded-[2rem] border border-[#131747]/10 bg-[linear-gradient(180deg,#ffffff_0%,rgba(19,23,71,0.02)_100%)] p-8 text-center transition duration-300 hover:-translate-y-2 hover:shadow-xl hover:shadow-[#131747]/5 relative overflow-hidden">
                        <div class="absolute inset-0 bg-[#131747] opacity-[0.02] pointer-events-none"></div>
                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-white border border-[#131747]/10 text-[#131747] shadow-sm mb-8 relative z-10">
                            <span class="font-bold text-xl tracking-widest">03</span>
                        </div>
                        <h3 class="text-xl font-bold text-[#131747] mb-4 relative z-10">Investment Timing</h3>
                        <p class="text-[#131747]/70 text-sm leading-relaxed relative z-10">Exactly when to invest, when to scale, and when to hold back.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- SaaS Core Tiers -->
        <div class="py-24 relative overflow-hidden">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_bottom_left,_rgba(255,64,64,0.05),_transparent_40%)]"></div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center max-w-3xl mx-auto mb-20 space-y-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-[#FF4040]">Deployment Options</p>
                    <h2 class="text-4xl font-extrabold text-[#131747]">Enterprise Pricing Packages</h2>
                    <p class="text-lg text-[#131747]/70">Access the Command Center at the tier that matches your organizational scale.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-center max-w-6xl mx-auto">
                    
                    <div v-for="(plan, index) in plans" :key="plan.slug" 
                         :class="plan.is_featured 
                            ? 'rounded-[2.5rem] border border-[#131747] bg-[#131747] p-10 shadow-[0_20px_60px_-15px_rgba(19,23,71,0.6)] transform md:-translate-y-4 relative overflow-hidden group'
                            : 'rounded-[2rem] border border-[#131747]/10 bg-white p-8 shadow-sm transition hover:shadow-xl hover:shadow-[#131747]/5'">

                        <div v-if="plan.is_featured" class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(255,64,64,0.2),_transparent_50%)]"></div>
                        <div v-if="plan.is_featured" class="absolute top-0 right-1/2 translate-x-1/2 bg-[#FF4040] text-white text-[10px] font-bold px-4 py-1.5 rounded-b-xl uppercase tracking-[0.2em] shadow-md shadow-[#FF4040]/30 z-10">
                            Most Popular
                        </div>

                        <div class="relative z-10" :class="{'pt-4': plan.is_featured}">
                            <div v-if="!plan.is_featured" class="mb-6 inline-flex rounded-full bg-[#131747]/5 px-4 py-1.5 text-[10px] font-bold uppercase tracking-[0.2em] text-[#131747]">Tier</div>
                            
                            <h3 class="text-2xl font-bold" :class="plan.is_featured ? 'text-white' : 'text-[#131747]'">{{ plan.name }}</h3>
                            <div class="my-6 flex items-baseline gap-2">
                                <span class="text-5xl font-extrabold tracking-tight" :class="plan.is_featured ? 'text-white' : 'text-[#131747]'">
                                    {{ plan.monthly_price ? '$' + (plan.monthly_price / 100) : 'Custom' }}
                                </span>
                                <span v-if="plan.monthly_price" class="text-sm font-semibold" :class="plan.is_featured ? 'text-white/50' : 'text-[#131747]/50'">/month</span>
                            </div>
                            <p class="text-sm mb-8 pb-8 border-b" :class="plan.is_featured ? 'text-white/70 border-white/10' : 'text-[#131747]/70 border-[#131747]/10'">{{ plan.description }}</p>
                            
                            <ul class="space-y-4 mb-8 text-sm" :class="plan.is_featured ? 'text-white/90' : 'text-[#131747]/80'">
                                <li v-if="!plan.feature_access || !plan.feature_access.length" class="flex items-start gap-3">
                                    <svg class="w-5 h-5 shrink-0" :class="plan.is_featured ? 'text-[#FF4040]' : 'text-[#131747]/40'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Complete feature set
                                </li>
                                <li v-for="feature in plan.feature_access" :key="feature" class="flex items-start gap-3" :class="{'font-semibold text-white': plan.is_featured}">
                                    <svg class="w-5 h-5 shrink-0" :class="plan.is_featured ? 'text-[#FF4040]' : 'text-[#FF4040]'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> 
                                    {{ feature.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase()) }}
                                </li>
                            </ul>
                            
                            <Link :href="route('register')" class="w-full inline-flex justify-center rounded-2xl px-6 py-4 text-sm font-semibold transition" 
                                :class="plan.is_featured 
                                    ? 'bg-[#FF4040] text-white shadow-xl shadow-[#FF4040]/25 hover:bg-[#e23535] hover:-translate-y-0.5' 
                                    : 'border border-[#131747]/20 bg-white text-[#131747] hover:bg-[#131747]/5 hover:border-[#131747]/30'">
                                {{ plan.monthly_price ? 'Begin Deployment' : 'Contact Architects' }}
                            </Link>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="relative overflow-hidden bg-[#131747] pt-24 pb-12 border-t border-white/10 mt-24">
            <!-- Background Glow -->
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[400px] bg-[radial-gradient(ellipse_at_top,_rgba(255,64,64,0.12),_transparent_70%)] pointer-events-none"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="flex flex-col items-center text-center space-y-6 mb-16">
                    <div class="flex items-center gap-3">
                        <ApplicationLogo class="max-w-24" />
                    </div>
                    <p class="text-white/60 text-sm leading-relaxed max-w-sm">
                        The automated financial command center for modern enterprises. Replace guesswork with predictive data and structured models.
                    </p>
                    <div class="flex gap-4 pt-2">
                        <!-- Social Icons -->
                        <a href="#" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center text-white/50 hover:bg-[#FF4040]/20 hover:border-[#FF4040]/50 hover:text-[#FF4040] border border-white/10 transition-all duration-300">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"></path></svg>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center text-white/50 hover:bg-[#FF4040]/20 hover:border-[#FF4040]/50 hover:text-[#FF4040] border border-white/10 transition-all duration-300">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"></path></svg>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center text-white/50 hover:bg-[#FF4040]/20 hover:border-[#FF4040]/50 hover:text-[#FF4040] border border-white/10 transition-all duration-300">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M19.812 5.418c.861.23 1.538.907 1.768 1.768C21.998 8.746 22 12 22 12s0 3.255-.418 4.814a2.504 2.504 0 0 1-1.768 1.768c-1.56.419-7.814.419-7.814.419s-6.255 0-7.814-.419a2.505 2.505 0 0 1-1.768-1.768C2 15.255 2 12 2 12s0-3.255.417-4.814a2.507 2.507 0 0 1 1.768-1.768C5.744 5 11.998 5 11.998 5s6.255 0 7.814.418ZM15.194 12 10 15V9l5.194 3Z" clip-rule="evenodd"></path></svg>
                        </a>
                    </div>
                </div>

                <!-- Footer Bottom -->
                <div class="pt-8 border-t border-white/10 flex flex-col md:flex-row justify-between items-center gap-4">
                    <p class="text-white/40 text-sm">
                        &copy; 2026 MR Calculators Core Logic. All operations secured.
                    </p>
                    <div class="flex items-center gap-3 bg-white/5 border border-white/10 rounded-full px-4 py-1.5 backdrop-blur-sm">
                        <span class="flex h-2 w-2">
                            <span class="absolute inline-flex h-2 w-2 animate-ping rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex h-2 w-2 rounded-full bg-emerald-500"></span>
                        </span>
                        <span class="text-white/70 text-xs font-semibold uppercase tracking-[0.1em]">All Systems Operational</span>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>
