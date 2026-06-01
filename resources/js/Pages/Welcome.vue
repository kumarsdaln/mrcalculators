<script setup>
    import PublicLayout from '@/Layouts/PublicLayout.vue';
    import CalculatorCard from '@/Components/Calculators/CalculatorCard.vue';
    import { Link } from '@inertiajs/vue3';
    import calculatorData from '@/data/calculators.json';
    import { useSubscription } from '@/Composable/useSubscription';

    const calculators = calculatorData.calculators;

    // Assuming you have Lucide Vue installed: npm install lucide-vue-next
    import {
        ArrowRight,
        ShieldCheck,
        Zap,
        BarChart3,
        Clock,
        CheckCircle2,
        Calculator,
        TrendingUp,
        Target,
        BarChart
    } from 'lucide-vue-next';

    defineProps({
        canLogin: Boolean,
        canRegister: Boolean,
        plans: {
            type: Array,
            default: () => [],
        },
    });

    const icons = {
        Target,
        Calculator,
        TrendingUp,
        Zap,
        BarChart,
    };
    const {
        canAccess,
        getCalculatorRoute,
        subscription
    } = useSubscription();
    const featureLabels = {
        monthly_sales_goal: 'Monthly Sales Goal Calculator',
        break_even_and_selling_price: 'Break-Even Pricing Calculator',
        future_sales_forecast: 'Future Revenue Estimator',
        what_if_profit_calculator: 'What-If Profit Calculator',
        marketing_cost_per_customer: 'Marketing Cost Per Customer Calculator'
    };
</script>

<template>
    <PublicLayout :can-login="canLogin" :can-register="canRegister" title="Martha Razo Financial Calculators">

        <!-- Hero Section -->
        <header class="relative pt-16 pb-16 overflow-hidden">
            <!-- Animated Background Blobs -->
            <div class="absolute top-0 -left-20 w-96 h-96 bg-[#FF4040]/10 rounded-full blur-[100px] animate-pulse">
            </div>
            <div class="absolute bottom-0 right-0 w-[500px] h-[500px] bg-[#131747]/5 rounded-full blur-[120px]"></div>

            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                    <div class="space-y-6 text-center lg:text-left">
                        <div
                            class="inline-flex items-center gap-2 rounded-full border border-[#FF4040]/20 bg-[#FF4040]/5 px-4 py-1.5 text-[11px] font-bold uppercase tracking-widest text-[#FF4040]">
                            <Zap :size="14" class="fill-[#FF4040]" />
                            Business Tools
                        </div>
                        <h1 class="text-5xl md:text-7xl font-black tracking-tight leading-[1.1] text-[#131747]">
                            Make Better <br />
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#FF4040] to-[#8a1d1d]">
                                Business Decisions
                            </span>
                        </h1>
                        <p class="text-lg md:text-xl text-[#131747]/60 max-w-xl mx-auto lg:mx-0 leading-relaxed">
                            Running a business is full of decisions.

                            How much should you charge?

                            How much do you need to sell?

                            Will you make a profit?

                            Are your marketing efforts working?

                            Our calculators help you find the answers quickly, so you can make decisions with more
                            confidence.
                        </p>

                        <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-4">
                            <Link :href="route('register')"
                                class="w-full sm:w-auto inline-flex items-center justify-center rounded-2xl bg-[#131747] px-8 py-4 text-base font-bold text-white shadow-2xl shadow-[#131747]/20 transition hover:-translate-y-1 hover:bg-[#FF4040] group">
                                Get Started
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
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Features Grid -->
        <section class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Section Heading -->
                <div class="max-w-3xl mx-auto text-center mb-14">
                    <span
                        class="inline-flex items-center rounded-full bg-[#FF4040]/5 border border-[#FF4040]/10 px-4 py-2 text-[11px] font-bold uppercase tracking-widest text-[#FF4040]">
                        Why Use Our Tools
                    </span>

                    <h2 class="mt-4 text-4xl md:text-5xl font-black tracking-tight text-[#131747]">
                        Get Clear Answers
                        <span class="block text-[#131747]/50">
                            Before You Make a Decision
                        </span>
                    </h2>

                    <p class="mt-5 text-lg text-[#131747]/60 leading-relaxed">
                        Running a business is full of important decisions. Our calculators
                        help you understand your numbers so you can plan with confidence.
                    </p>
                </div>

                <!-- Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                    <!-- Card 1 -->
                    <div
                        class="group p-8 rounded-3xl border border-transparent hover:border-gray-100 hover:bg-gray-50/50 transition-all">
                        <div
                            class="w-14 h-14 rounded-2xl bg-[#131747] text-white flex items-center justify-center mb-6 group-hover:scale-110 transition-transform shadow-lg shadow-[#131747]/20">
                            <BarChart3 :size="28" />
                        </div>

                        <h3 class="text-xl font-bold mb-3 text-[#131747]">
                            Set Better Sales Goals
                        </h3>

                        <p class="text-gray-500 leading-relaxed text-sm">
                            Know exactly how much you need to sell each month to reach
                            your business goals and stay on track.
                        </p>
                    </div>

                    <!-- Card 2 -->
                    <div
                        class="group p-8 rounded-3xl border border-transparent hover:border-gray-100 hover:bg-gray-50/50 transition-all">
                        <div
                            class="w-14 h-14 rounded-2xl bg-[#FF4040] text-white flex items-center justify-center mb-6 group-hover:scale-110 transition-transform shadow-lg shadow-[#FF4040]/20">
                            <ShieldCheck :size="28" />
                        </div>

                        <h3 class="text-xl font-bold mb-3 text-[#131747]">
                            Price with Confidence
                        </h3>

                        <p class="text-gray-500 leading-relaxed text-sm">
                            Make sure you're charging enough to cover your costs and
                            earn the profit you want.
                        </p>
                    </div>

                    <!-- Card 3 -->
                    <div
                        class="group p-8 rounded-3xl border border-transparent hover:border-gray-100 hover:bg-gray-50/50 transition-all">
                        <div
                            class="w-14 h-14 rounded-2xl bg-[#F3F4F6] text-[#131747] flex items-center justify-center mb-6 group-hover:scale-110 transition-transform shadow-sm">
                            <Clock :size="28" />
                        </div>

                        <h3 class="text-xl font-bold mb-3 text-[#131747]">
                            Plan Ahead
                        </h3>

                        <p class="text-gray-500 leading-relaxed text-sm">
                            See how changes in sales, expenses, or marketing could affect
                            your business before you make important decisions.
                        </p>
                    </div>

                </div>
            </div>
        </section>

        <!-- Calculators Deep-Dive Section -->
        <section id="calculators" class="py-24 bg-[#FDFDFD]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">

                    <p class="text-[11px] font-bold uppercase tracking-widest text-[#FF4040] mb-3">
                        Our Calculators
                    </p>

                    <h2 class="text-4xl md:text-5xl font-black text-[#131747] mb-4">
                        Simple Tools for
                        <br />
                        Better Business Decisions
                    </h2>

                    <p class="text-[#131747]/60 max-w-3xl mx-auto text-lg leading-relaxed">
                        Whether you're setting sales goals, pricing your products or
                        services, checking your profits, or planning for growth, these
                        calculators help you understand your numbers and make more
                        informed decisions.
                    </p>

                </div>

                <!-- Top row: 3 cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <CalculatorCard v-for="tool in calculators" :key="tool.slug" :calculator="tool"
                        :icon="icons[tool.icon]" :has-access="canAccess(tool.slug)" :href="getCalculatorRoute(tool)" />
                </div>

            </div>
        </section>


        <!-- Pricing Section -->
        <section class="py-20 bg-white relative overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Heading -->
                <div class="text-center mb-14">
                    <p class="text-[11px] font-bold uppercase tracking-widest text-[#FF4040] mb-3">
                        Pricing
                    </p>

                    <h2 class="text-4xl md:text-5xl font-black text-[#131747] mb-4">
                        Choose the Plan That's Right for You
                    </h2>

                    <p class="text-[#131747]/60 max-w-2xl mx-auto text-lg leading-relaxed">
                        Start with the essentials or unlock all calculators to help you
                        set goals, improve pricing, understand profits, and make better
                        business decisions.
                    </p>
                </div>

                <!-- Pricing Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">

                    <div v-for="plan in plans" :key="plan.slug"
                        class="relative p-8 rounded-[2.5rem] border transition-all duration-300" :class="plan.is_featured
                                ? 'bg-[#131747] text-white border-[#131747] scale-105 shadow-2xl shadow-[#131747]/20'
                                : 'bg-white text-[#131747] border-gray-100 shadow-sm hover:shadow-xl'
                            ">

                        <!-- Featured Badge -->
                        <div v-if="plan.is_featured"
                            class="absolute -top-4 left-1/2 -translate-x-1/2 rounded-full bg-[#FF4040] px-4 py-1 text-[10px] font-bold uppercase tracking-widest text-white">
                            Most Popular
                        </div>

                        <!-- Plan Name -->
                        <h3 class="text-2xl font-black mb-3">
                            {{ plan.name }}
                        </h3>

                        <!-- Price -->
                        <div class="flex items-end gap-2 mb-4">
                            <span class="text-5xl font-black">
                                {{
                                    plan.monthly_price
                                        ? '$' + (plan.monthly_price / 100)
                                        : 'Custom'
                                }}
                            </span>

                            <span v-if="plan.monthly_price" class="text-sm opacity-60 pb-2">
                                /month
                            </span>
                        </div>

                        <!-- Description -->
                        <p class="text-sm leading-relaxed mb-8 opacity-75">
                            {{
                                plan.slug === 'free'
                                    ? 'Perfect for business owners who want access to essential planning and pricing tools.'
                                    : plan.slug === 'premium'
                                        ? 'Get access to all calculators and tools to help you make confident business decisions.'
                                        : 'Need something more tailored? Contact us to discuss a solution that fits your business.'
                            }}
                        </p>

                        <!-- Features -->
                        <ul class="space-y-4 mb-10">
                            <li v-for="feature in plan.feature_access" :key="feature"
                                class="flex items-start gap-3 text-sm">
                                <CheckCircle2 :size="18" class="mt-0.5 shrink-0" :class="plan.is_featured
                                        ? 'text-[#FF4040]'
                                        : 'text-green-500'
                                    " />

                                <span>
                                    {{
                                        featureLabels[feature] ||
                                        feature.replace(/_/g, ' ')
                                    }}
                                </span>
                            </li>
                        </ul>

                        <!-- CTA -->
                        <Link :href="route('register')"
                            class="block w-full rounded-2xl py-4 text-center text-sm font-bold transition-all" :class="plan.is_featured
                                    ? 'bg-[#FF4040] text-white hover:bg-white hover:text-[#131747]'
                                    : 'bg-gray-100 text-[#131747] hover:bg-[#131747] hover:text-white'
                                ">
                            {{
                                !plan.monthly_price
                                    ? 'Contact Us'
                                    : plan.slug === 'free'
                                        ? 'Get Started'
                                        : 'Choose Plan'
                            }}
                        </Link>

                    </div>

                </div>

                <!-- Bottom Text -->
                <div class="mt-12 text-center">
                    <p class="text-sm text-[#131747]/50">
                        Not sure which plan is right for you?
                        Contact us and we'll help you choose the best option for your business.
                    </p>
                </div>

            </div>
        </section>

    </PublicLayout>
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