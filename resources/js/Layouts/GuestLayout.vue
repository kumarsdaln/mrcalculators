<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { ShieldCheck, Zap, BarChart3, Globe } from 'lucide-vue-next';

const page = usePage();
const flash = computed(() => page.props.flash ?? {});
</script>

<template>
    <div class="relative min-h-screen overflow-hidden bg-[#FDFDFF] selection:bg-[#FF4040]/10 selection:text-[#FF4040]">
        
        <!-- Animated Mesh Gradient Background -->
        <div class="absolute inset-0 z-0">
            <div class="absolute -top-[10%] -left-[10%] h-[50%] w-[50%] rounded-full bg-[#FF4040]/5 blur-[120px] animate-pulse"></div>
            <div class="absolute top-[20%] -right-[10%] h-[60%] w-[50%] rounded-full bg-[#131747]/5 blur-[120px]"></div>
            <div class="absolute -bottom-[10%] left-[20%] h-[40%] w-[40%] rounded-full bg-[#FF4040]/5 blur-[100px] animate-pulse" style="animation-delay: 2s;"></div>
        </div>

        <div class="relative z-10 mx-auto flex min-h-screen max-w-[1440px] items-center px-4 py-6 sm:px-6 lg:px-12">
            <div class="grid w-full gap-8 lg:grid-cols-[1.2fr,0.8fr] lg:items-stretch">
                
                <!-- Left Sidebar (The "Experience" Side) -->
                <div class="hidden overflow-hidden rounded-[3rem] bg-[#131747] shadow-[0_40px_100px_-20px_rgba(19,23,71,0.4)] lg:relative lg:flex lg:flex-col">
                    <!-- Subtle Pattern Overlay -->
                    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#fff 0.5px, transparent 0.5px); background-size: 24px 24px;"></div>
                    
                    <div class="relative flex h-full flex-col justify-between p-16">
                        <div class="space-y-12">
                            <!-- Premium Logo Branding -->
                            <Link href="/" class="group flex items-center">
                                <div class="flex">
                                    <ApplicationLogo class="max-w-24 w-20 object-contain brightness-0 invert" />
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-xl font-black tracking-tight text-white">CALCULATORS</span>
                                </div>
                            </Link>

                            <div class="space-y-8">
                                <div class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-4 py-1.5 backdrop-blur-md">
                                    <Zap :size="14" class="text-[#FF4040]" />
                                    <span class="text-[10px] font-black uppercase tracking-widest text-white/80">v3.0 Now Live</span>
                                </div>
                                
                                <h1 class="max-w-md text-6xl font-black leading-[1.05] tracking-tighter text-white">
                                    Command your <span class="bg-gradient-to-r from-[#FF4040] to-[#ff7b7b] bg-clip-text text-transparent">revenue.</span>
                                </h1>
                                
                                <p class="max-w-sm text-lg leading-relaxed text-white/50">
                                    Strategic forecasting and automated subscription management engineered for high-growth teams.
                                </p>
                            </div>
                        </div>

                        <!-- Interactive Feature Pills -->
                        <div class="grid gap-3">
                            <div class="flex items-center gap-4 rounded-3xl border border-white/5 bg-white/[0.03] p-4 transition-colors hover:bg-white/[0.06]">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#FF4040]/20 text-[#FF4040]">
                                    <BarChart3 :size="20" />
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-white">Predictive Engine</p>
                                    <p class="text-xs text-white/40">Real-time quota and break-even modeling.</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 rounded-3xl border border-white/5 bg-white/[0.03] p-4 transition-colors hover:bg-white/[0.06]">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white/10 text-white">
                                    <Globe :size="20" />
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-white">Global Billing</p>
                                    <p class="text-xs text-white/40">Native Stripe integration for seamless scale.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side (The "Action" Side) -->
                <div class="flex flex-col justify-center lg:px-6">
                    <!-- Mobile Header (Visible only on small screens) -->
                    <div class="mb-10 flex flex-col items-center text-center lg:hidden">
                        <Link href="/" class="mb-6 flex h-20 w-20 items-center justify-center rounded-[2rem] bg-white p-5 shadow-2xl shadow-[#131747]/10">
                            <ApplicationLogo class="h-full w-full object-contain" />
                        </Link>
                        <h2 class="text-3xl font-black tracking-tight text-[#131747]">MR Calculators</h2>
                        <p class="mt-2 text-sm font-bold tracking-widest text-[#FF4040]">FINANCE OPERATING SYSTEM</p>
                    </div>

                    <div class="relative w-full rounded-[3rem] border border-[#131747]/5 bg-white p-8 shadow-[0_50px_100px_-30px_rgba(19,23,71,0.12)] sm:p-14">
                        
                        <!-- Flash Notification System -->
                        <div v-if="flash.success || flash.error" class="mb-10">
                            <Transition
                                enter-active-class="transform transition duration-300 ease-out"
                                enter-from-class="scale-95 opacity-0 -translate-y-2"
                                enter-to-class="scale-100 opacity-100 translate-y-0"
                            >
                                <div v-if="flash.success" class="flex items-center gap-3 rounded-2xl bg-emerald-50 p-4 text-emerald-700 ring-1 ring-inset ring-emerald-200">
                                    <ShieldCheck :size="18" />
                                    <p class="text-xs font-bold uppercase tracking-wide">{{ flash.success }}</p>
                                </div>
                            </Transition>
                            
                            <Transition
                                enter-active-class="transform transition duration-300 ease-out"
                                enter-from-class="scale-95 opacity-0 -translate-y-2"
                                enter-to-class="scale-100 opacity-100 translate-y-0"
                            >
                                <div v-if="flash.error" class="flex items-center gap-3 rounded-2xl bg-red-50 p-4 text-red-700 ring-1 ring-inset ring-red-200">
                                    <ShieldCheck :size="18" />
                                    <p class="text-xs font-bold uppercase tracking-wide">{{ flash.error }}</p>
                                </div>
                            </Transition>
                        </div>

                        <!-- Slot for Form Content -->
                        <slot />

                        <!-- Enhanced Footer Security Mark -->
                        <div class="mt-12 flex items-center justify-center gap-6 opacity-30 grayscale transition-all hover:grayscale-0 hover:opacity-100">
                            <div class="h-px flex-1 bg-gradient-to-r from-transparent to-[#131747]/20"></div>
                            <div class="flex items-center gap-2">
                                <ShieldCheck :size="14" />
                                <span class="text-[10px] font-bold uppercase tracking-widest">AES-256 Encrypted</span>
                            </div>
                            <div class="h-px flex-1 bg-gradient-to-l from-transparent to-[#131747]/20"></div>
                        </div>
                    </div>

                    <!-- External Links -->
                    <div class="mt-8 flex justify-center gap-8 text-[11px] font-bold uppercase tracking-widest text-[#131747]/40 transition-colors">
                        <Link :href="route('privacy-policy')" class="hover:text-[#FF4040]">Privacy Policy</Link>
                        <Link :href="route('terms-conditions')" class="hover:text-[#FF4040]">Terms of Service</Link>
                        <Link :href="route('disclaimer')" class="hover:text-[#FF4040]">Disclaimer</Link>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<style scoped>
@keyframes pulse {
    0%, 100% { opacity: 0.5; transform: scale(1); }
    50% { opacity: 0.8; transform: scale(1.05); }
}
.animate-pulse {
    animation: pulse 8s infinite ease-in-out;
}
</style>