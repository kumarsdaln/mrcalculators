<script setup>
    import ApplicationLogo from '@/Components/ApplicationLogo.vue';
    import { Head, Link } from '@inertiajs/vue3';
    // Assuming you have Lucide Vue installed: npm install lucide-vue-next
    import {
        LayoutDashboard,
        ArrowRight,
        TrendingUp,
        ShieldCheck,
        Zap,
        BarChart3,
        Clock,
        CheckCircle2,
        Lock,
        Twitter,
        Github,
        Linkedin,
        Youtube,
        ExternalLink
    } from 'lucide-vue-next';

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

    <Head title="MR Calculators | Financial Intelligence" />

    <div class="min-h-screen bg-[#FDFDFD] text-[#131747] font-sans selection:bg-[#FF4040] selection:text-white">
        <!-- Navigation -->
        <nav class="sticky top-0 z-50 border-b border-[#131747]/5 bg-white/70 backdrop-blur-md">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-20">
                    <div class="flex items-center gap-2 group cursor-pointer">
                        <ApplicationLogo class="max-h-24 w-20 transition-transform group-hover:scale-105" />
                        <span class="font-bold text-xl tracking-tight hidden sm:block">MR<span
                                class="text-[#FF4040]">Calculators</span></span>
                    </div>

                    <div v-if="canLogin" class="flex gap-6 items-center">
                        <Link v-if="$page.props.auth.user" :href="route('dashboard')"
                            class="inline-flex items-center gap-2 rounded-xl bg-[#131747] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#FF4040] hover:shadow-lg hover:shadow-[#FF4040]/20">
                            <LayoutDashboard :size="18" />
                            Dashboard
                        </Link>
                        <template v-else>
                            <Link :href="route('login')"
                                class="text-sm font-semibold text-[#131747]/70 hover:text-[#FF4040] transition">
                                Login
                            </Link>
                            <Link v-if="canRegister" :href="route('register')"
                                class="inline-flex items-center justify-center rounded-xl bg-[#FF4040] px-6 py-2.5 text-sm font-bold text-white shadow-lg shadow-[#FF4040]/20 transition hover:-translate-y-0.5 hover:bg-[#e23535]">
                                Get Started
                            </Link>
                        </template>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <header class="relative pt-20 pb-32 overflow-hidden">
            <!-- Animated Background Blobs -->
            <div class="absolute top-0 -left-20 w-96 h-96 bg-[#FF4040]/10 rounded-full blur-[100px] animate-pulse">
            </div>
            <div class="absolute bottom-0 right-0 w-[500px] h-[500px] bg-[#131747]/5 rounded-full blur-[120px]"></div>

            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div class="space-y-8 text-center lg:text-left">
                        <div
                            class="inline-flex items-center gap-2 rounded-full border border-[#FF4040]/20 bg-[#FF4040]/5 px-4 py-1.5 text-[11px] font-bold uppercase tracking-widest text-[#FF4040]">
                            <Zap :size="14" class="fill-[#FF4040]" />
                            The New Era of Financial Modeling
                        </div>
                        <h1 class="text-5xl md:text-7xl font-black tracking-tight leading-[1.1] text-[#131747]">
                            Stop Guessing. <br />
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#FF4040] to-[#8a1d1d]">
                                Scale with Clarity.
                            </span>
                        </h1>
                        <p class="text-lg md:text-xl text-[#131747]/60 max-w-xl mx-auto lg:mx-0 leading-relaxed">
                            Stop relying on "gut feeling." Use our automated command center to simulate sales scenarios,
                            validate profit margins, and forecast your growth with surgical precision.
                        </p>

                        <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-4">
                            <Link :href="route('register')"
                                class="w-full sm:w-auto inline-flex items-center justify-center rounded-2xl bg-[#131747] px-8 py-4 text-base font-bold text-white shadow-2xl shadow-[#131747]/20 transition hover:-translate-y-1 hover:bg-[#FF4040] group">
                                Start Your Forecast
                                <ArrowRight class="ml-2 w-5 h-5 group-hover:translate-x-1 transition-transform" />
                            </Link>
                            <div class="flex -space-x-3 overflow-hidden p-2">
                                <img class="inline-block h-10 w-10 rounded-full ring-2 ring-white"
                                    src="https://i.pravatar.cc/100?u=1" alt="">
                                <img class="inline-block h-10 w-10 rounded-full ring-2 ring-white"
                                    src="https://i.pravatar.cc/100?u=2" alt="">
                                <img class="inline-block h-10 w-10 rounded-full ring-2 ring-white"
                                    src="https://i.pravatar.cc/100?u=3" alt="">
                                <div
                                    class="flex items-center justify-center h-10 w-10 rounded-full bg-gray-100 ring-2 ring-white text-[10px] font-bold text-gray-500">
                                    +500</div>
                            </div>
                        </div>
                    </div>

                    <!-- Hero Visual -->
                    <div class="relative lg:ml-10">
                        <div
                            class="relative z-20 rounded-3xl border border-white/40 bg-white/20 backdrop-blur-sm p-4 shadow-[0_32px_64px_-16px_rgba(0,0,0,0.1)]">
                            <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?q=80&w=2426&auto=format&fit=crop"
                                class="rounded-2xl shadow-inner w-full h-auto object-cover aspect-video"
                                alt="Dashboard Preview" />

                            <!-- Floating Stat 1 -->
                            <div class="absolute -left-8 top-1/4 animate-float hidden sm:block">
                                <div
                                    class="bg-white p-4 rounded-2xl shadow-xl flex items-center gap-3 border border-gray-100">
                                    <div class="p-2 bg-green-100 rounded-lg text-green-600">
                                        <TrendingUp :size="20" />
                                    </div>
                                    <div>
                                        <div class="text-[10px] text-gray-400 font-bold uppercase">Accuracy</div>
                                        <div class="text-lg font-bold">99.4%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Features Grid -->
        <section class="py-24 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                    <div
                        class="group p-8 rounded-3xl border border-transparent hover:border-gray-100 hover:bg-gray-50/50 transition-all">
                        <div
                            class="w-14 h-14 rounded-2xl bg-[#131747] text-white flex items-center justify-center mb-6 group-hover:scale-110 transition-transform shadow-lg shadow-[#131747]/20">
                            <BarChart3 :size="28" />
                        </div>
                        <h3 class="text-xl font-bold mb-3 text-[#131747]">Revenue Predictability</h3>
                        <p class="text-gray-500 leading-relaxed text-sm">Automated algorithms analyze your current
                            velocity to
                            project future cash flow with realistic confidence intervals.</p>
                    </div>

                    <div
                        class="group p-8 rounded-3xl border border-transparent hover:border-gray-100 hover:bg-gray-50/50 transition-all">
                        <div
                            class="w-14 h-14 rounded-2xl bg-[#FF4040] text-white flex items-center justify-center mb-6 group-hover:scale-110 transition-transform shadow-lg shadow-[#FF4040]/20">
                            <ShieldCheck :size="28" />
                        </div>
                        <h3 class="text-xl font-bold mb-3 text-[#131747]">Strategy Validation</h3>
                        <p class="text-gray-500 leading-relaxed text-sm">Run "What If" scenarios to see how price
                            changes or
                            marketing spend impacts your bottom line before you spend a dime.</p>
                    </div>

                    <div
                        class="group p-8 rounded-3xl border border-transparent hover:border-gray-100 hover:bg-gray-50/50 transition-all">
                        <div
                            class="w-14 h-14 rounded-2xl bg-[#F3F4F6] text-[#131747] flex items-center justify-center mb-6 group-hover:scale-110 transition-transform shadow-sm">
                            <Clock :size="28" />
                        </div>
                        <h3 class="text-xl font-bold mb-3 text-[#131747]">Investment Timing</h3>
                        <p class="text-gray-500 leading-relaxed text-sm">Know exactly when you'll have the capital to
                            hire,
                            scale, or upgrade your infrastructure without risking liquidity.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Pricing Section -->
        <section class="py-24 relative overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-black text-[#131747] mb-4">Transparent Pricing</h2>
                    <p class="text-gray-500">Pick the plan that matches your current business stage.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                    <div v-for="plan in plans" :key="plan.slug"
                        class="relative p-8 rounded-[2.5rem] border transition-all duration-500" :class="plan.is_featured
                            ? 'bg-[#131747] text-white border-[#131747] scale-105 shadow-2xl shadow-[#131747]/30'
                            : 'bg-white text-[#131747] border-gray-100 shadow-sm hover:shadow-xl'">

                        <div v-if="plan.is_featured"
                            class="absolute -top-4 left-1/2 -translate-x-1/2 bg-[#FF4040] text-white text-[10px] font-bold px-4 py-1 rounded-full uppercase tracking-widest">
                            Most Popular
                        </div>

                        <h3 class="text-xl font-bold mb-2">{{ plan.name }}</h3>
                        <div class="flex items-baseline gap-1 mb-4">
                            <span class="text-4xl font-black">{{ plan.monthly_price ? '$' + (plan.monthly_price / 100) :
                                'Custom' }}</span>
                            <span v-if="plan.monthly_price" class="text-xs opacity-60">/month</span>
                        </div>

                        <p class="text-sm mb-8 opacity-70 leading-relaxed">{{ plan.description }}</p>

                        <ul class="space-y-4 mb-10">
                            <li v-for="feature in plan.feature_access" :key="feature"
                                class="flex items-center gap-3 text-sm">
                                <CheckCircle2 :size="18"
                                    :class="plan.is_featured ? 'text-[#FF4040]' : 'text-green-500'" />
                                {{feature.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase())}}
                            </li>
                        </ul>

                        <Link :href="route('register')"
                            class="block w-full py-4 rounded-2xl text-center font-bold text-sm transition-all" :class="plan.is_featured
                                ? 'bg-[#FF4040] text-white hover:bg-white hover:text-[#131747]'
                                : 'bg-gray-100 text-[#131747] hover:bg-[#131747] hover:text-white'">
                            {{ plan.monthly_price ? 'Begin Deployment' : 'Contact Us' }}
                        </Link>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-[#131747] text-white/80 pt-20 pb-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-12 pb-16">
                    <!-- Brand and Description -->
                    <div class="md:col-span-2 space-y-6 text-center md:text-left">
                        <div class="flex items-center justify-center md:justify-start">
                            <ApplicationLogo class="max-h-24 w-20 invert brightness-0" />
                            <span class="text-xl font-bold text-white">Calculators</span>
                        </div>
                        <p class="max-w-sm text-sm leading-relaxed mx-auto md:mx-0 text-white/60">
                            The definitive financial command center for modern enterprises. Replace messy spreadsheets
                            with
                            actionable intelligence.
                        </p>

                        <!-- Social Media Icons -->
                        <div class="flex items-center justify-center md:justify-start gap-4 pt-2">
                            <a href="#"
                                class="p-2.5 rounded-xl bg-white/5 hover:bg-[#FF4040] hover:text-white transition-all duration-300 group"
                                aria-label="Twitter">
                                <Twitter :size="20" class="group-hover:scale-110 transition-transform" />
                            </a>
                            <a href="#"
                                class="p-2.5 rounded-xl bg-white/5 hover:bg-[#FF4040] hover:text-white transition-all duration-300 group"
                                aria-label="LinkedIn">
                                <Linkedin :size="20" class="group-hover:scale-110 transition-transform" />
                            </a>
                            <a href="#"
                                class="p-2.5 rounded-xl bg-white/5 hover:bg-[#FF4040] hover:text-white transition-all duration-300 group"
                                aria-label="GitHub">
                                <Github :size="20" class="group-hover:scale-110 transition-transform" />
                            </a>
                            <a href="#"
                                class="p-2.5 rounded-xl bg-white/5 hover:bg-[#FF4040] hover:text-white transition-all duration-300 group"
                                aria-label="YouTube">
                                <Youtube :size="20" class="group-hover:scale-110 transition-transform" />
                            </a>
                        </div>
                    </div>

                    <!-- Quick Links (Optional but recommended) -->
                    <div class="hidden md:block">
                        <h4 class="text-white font-bold mb-6 text-sm uppercase tracking-widest">Product</h4>
                        <ul class="space-y-4 text-sm">
                            <li><a href="#" class="hover:text-[#FF4040] transition">Calculators</a></li>
                            <li><a href="#" class="hover:text-[#FF4040] transition">Pricing</a></li>
                            <li><a href="#" class="hover:text-[#FF4040] transition">Documentation</a></li>
                        </ul>
                    </div>

                    <!-- Status & Support -->
                    <div class="flex flex-col items-center md:items-end space-y-6">
                        <div class="flex items-center gap-3 px-4 py-2 bg-white/5 border border-white/10 rounded-full">
                            <span class="relative flex h-2 w-2">
                                <span
                                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                            </span>
                            <span class="text-[10px] font-bold uppercase tracking-widest text-white">Systems
                                Online</span>
                        </div>
                        <a href="mailto:support@mrcalculators.com"
                            class="text-sm font-medium hover:text-[#FF4040] transition flex items-center gap-2">
                            Contact Support
                            <ExternalLink :size="14" />
                        </a>
                    </div>
                </div>

                <div
                    class="pt-8 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-6 text-xs text-white/40">
                    <p>&copy; 2026 MR Calculators Core Logic. All rights reserved.</p>
                    <div class="flex gap-8">
                        <a href="#" class="hover:text-white transition">Privacy Policy</a>
                        <a href="#" class="hover:text-white transition">Terms of Service</a>
                        <a href="#" class="hover:text-white transition">Cookies</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>

<style scoped>
    @keyframes float {
        0% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(-10px);
        }

        100% {
            transform: translateY(0px);
        }
    }

    .animate-float {
        animation: float 4s ease-in-out infinite;
    }

    /* Smooth color transitions for the gradient text */
    .bg-gradient-to-r {
        background-size: 200% auto;
        animation: gradient 5s linear infinite;
    }

    @keyframes gradient {
        0% {
            background-position: 0% 50%;
        }

        50% {
            background-position: 100% 50%;
        }

        100% {
            background-position: 0% 50%;
        }
    }
</style>