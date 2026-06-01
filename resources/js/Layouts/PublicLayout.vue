<script setup>
    import ApplicationLogo from '@/Components/ApplicationLogo.vue';
    import { Head, Link } from '@inertiajs/vue3';

    // Assuming you have Lucide Vue installed: npm install lucide-vue-next
    import {
        LayoutDashboard,
        Twitter,
        Github,
        Linkedin,
        Youtube,
        ExternalLink,
    } from 'lucide-vue-next';

    defineProps({
        canLogin: Boolean,
        canRegister: Boolean,
        title: {
            type: String,
            default: 'MR Calculators | Financial Intelligence'
        }
    });
</script>

<template>

    <Head :title="title" />

    <div class="min-h-screen bg-[#FDFDFD] text-[#131747] font-sans selection:bg-[#FF4040] selection:text-white">
        <!-- Navigation -->
        <nav class="sticky top-0 z-50 border-b border-[#131747]/5 bg-white/70 backdrop-blur-md">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-20">
                    <Link :href="route('home')" class="flex items-center gap-3">
                        <ApplicationLogo class="max-h-24 w-20 transition-transform group-hover:scale-105" />
                    </Link>

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

        <slot />

        <!-- Footer -->
        <footer class="bg-[#131747] text-white/80 pt-20 pb-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8 pb-16">
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
                        <Link :href="route('privacy-policy')" class="hover:text-white transition">Privacy Policy</Link>
                        <Link :href="route('terms-conditions')" class="hover:text-white transition">Terms of Service</Link>
                        <Link :href="route('disclaimer')" class="hover:text-white transition">Disclaimer</Link>
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