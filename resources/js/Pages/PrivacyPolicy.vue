<script setup>
    import LegalContactCard from '@/Components/LegalContactCard.vue';
    import PublicLayout from '@/Layouts/PublicLayout.vue';
    defineProps({
        canLogin: Boolean,
        canRegister: Boolean,
    });
</script>

<template>
    <PublicLayout :can-login="canLogin" :can-register="canRegister" title="Privacy Policy">

        <div class="py-12">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <!-- Hero -->
                <div
                    class="relative overflow-hidden rounded-[2.5rem] border border-[#131747] bg-[#131747] p-8 md:p-14 text-white shadow-2xl">
                    <div
                        class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(255,64,64,0.3),_transparent_40%)]">
                    </div>

                    <div class="relative z-10 max-w-4xl">
                        <div
                            class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-4 py-2 text-[10px] font-black uppercase tracking-widest">
                            Privacy Policy
                        </div>

                        <h1 class="mt-6 text-4xl md:text-6xl font-black tracking-tight">
                            Your Privacy Matters
                        </h1>

                        <p class="mt-6 text-lg leading-relaxed text-white/70 max-w-3xl">
                            We value your trust and are committed to protecting
                            your personal information. This Privacy Policy
                            explains how we collect, use, and safeguard your
                            information when you use our calculators and
                            services.
                        </p>

                        <p class="mt-6 text-sm font-medium text-white/40">
                            Last Updated: June 2026
                        </p>
                    </div>
                </div>

                <!-- Content -->
                <div class="mt-8 space-y-6">

                    <section class="bg-white rounded-3xl border border-[#131747]/10 p-8">
                        <h2 class="text-2xl font-bold text-[#131747]">
                            Introduction
                        </h2>

                        <p class="mt-4 text-[#131747]/70 leading-8">
                            Welcome to Martha Razo Financial Calculators. We
                            respect your privacy and are committed to protecting
                            the personal information you share with us.
                        </p>
                    </section>

                    <section class="bg-white rounded-3xl border border-[#131747]/10 p-8">
                        <h2 class="text-2xl font-bold text-[#131747]">
                            Information We Collect
                        </h2>

                        <div class="mt-6 space-y-4 text-[#131747]/70 leading-8">
                            <p>
                                We may collect information that you voluntarily
                                provide, including:
                            </p>

                            <ul class="list-disc pl-6 space-y-2">
                                <li>Name</li>
                                <li>Email Address</li>
                                <li>Account Information</li>
                                <li>Billing Information</li>
                                <li>Calculator Inputs and Preferences</li>
                            </ul>

                            <p>
                                We may also automatically collect technical
                                information such as browser type, device
                                information, IP address, and usage analytics.
                            </p>
                        </div>
                    </section>

                    <section class="bg-white rounded-3xl border border-[#131747]/10 p-8">
                        <h2 class="text-2xl font-bold text-[#131747]">
                            How We Use Your Information
                        </h2>

                        <ul class="mt-6 list-disc pl-6 space-y-3 text-[#131747]/70 leading-8">
                            <li>Provide calculator functionality</li>
                            <li>Manage subscriptions and billing</li>
                            <li>Improve user experience</li>
                            <li>Respond to support requests</li>
                            <li>Maintain security and prevent abuse</li>
                            <li>Comply with legal obligations</li>
                        </ul>
                    </section>

                    <section class="bg-white rounded-3xl border border-[#131747]/10 p-8">
                        <h2 class="text-2xl font-bold text-[#131747]">
                            Calculator Data
                        </h2>

                        <p class="mt-4 text-[#131747]/70 leading-8">
                            Information entered into calculators is used to
                            generate results and improve platform functionality.
                            We do not sell your calculator data to third parties.
                        </p>
                    </section>

                    <section class="bg-white rounded-3xl border border-[#131747]/10 p-8">
                        <h2 class="text-2xl font-bold text-[#131747]">
                            Cookies
                        </h2>

                        <p class="mt-4 text-[#131747]/70 leading-8">
                            We may use cookies and similar technologies to keep
                            users logged in, remember preferences, analyze
                            website usage, and improve overall performance.
                        </p>
                    </section>

                    <section class="bg-white rounded-3xl border border-[#131747]/10 p-8">
                        <h2 class="text-2xl font-bold text-[#131747]">
                            Data Security
                        </h2>

                        <p class="mt-4 text-[#131747]/70 leading-8">
                            We implement reasonable security measures to protect
                            your information. While we work hard to safeguard
                            data, no system can guarantee absolute security.
                        </p>
                    </section>

                    <section class="bg-white rounded-3xl border border-[#131747]/10 p-8">
                        <h2 class="text-2xl font-bold text-[#131747]">
                            Your Rights
                        </h2>

                        <ul class="mt-6 list-disc pl-6 space-y-3 text-[#131747]/70 leading-8">
                            <li>Request access to your data</li>
                            <li>Correct inaccurate information</li>
                            <li>Request deletion of personal data</li>
                            <li>Withdraw consent where applicable</li>
                        </ul>
                    </section>

                    <section class="bg-white rounded-3xl border border-[#131747]/10 p-8">
                        <h2 class="text-2xl font-bold text-[#131747]">
                            Changes to This Policy
                        </h2>

                        <p class="mt-4 text-[#131747]/70 leading-8">
                            We may update this Privacy Policy periodically.
                            Changes will be posted on this page along with the
                            updated revision date.
                        </p>
                    </section>

                    <!-- Contact -->
                    <LegalContactCard title="Privacy Questions?"
                        description="If you have questions about how your information is collected, used, or protected, please contact us." />

                </div>
            </div>
        </div>

    </PublicLayout>
</template>