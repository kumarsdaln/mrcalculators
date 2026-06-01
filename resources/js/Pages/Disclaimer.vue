<script setup>
    import LegalContactCard from '@/Components/LegalContactCard.vue';
    import PublicLayout from '@/Layouts/PublicLayout.vue';
    defineProps({
        canLogin: Boolean,
        canRegister: Boolean,
    });
</script>

<template>
    <PublicLayout :can-login="canLogin" :can-register="canRegister" title="Disclaimer">

        <div class="py-12">
            <div class="max-w-7xl mx-auto px-6 lg:px-8"> <!-- Hero -->
                <div
                    class="relative overflow-hidden rounded-[2.5rem] border border-[#131747] bg-[#131747] p-8 md:p-14 text-white shadow-2xl">
                    <div
                        class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(255,64,64,0.3),_transparent_40%)]" />
                    <div class="relative z-10 max-w-4xl">
                        <div
                            class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-4 py-2 text-[10px] font-black uppercase tracking-widest">
                            <AlertTriangle class="h-4 w-4" /> Disclaimer
                        </div>
                        <h1 class="mt-6 text-4xl md:text-6xl font-black tracking-tight"> Important Information </h1>
                        <p class="mt-6 max-w-3xl text-lg leading-relaxed text-white/70"> Our calculators are designed to
                            help you better understand business metrics, financial planning, pricing strategies, and
                            growth opportunities. Results should be used as informational tools and not as professional
                            financial, legal, tax, or investment advice. </p>
                        <p class="mt-6 text-sm text-white/40"> Last Updated: June 2026 </p>
                    </div>
                </div> <!-- Content -->
                <div class="mt-8 space-y-6"> <!-- General Disclaimer -->
                    <section class="rounded-3xl border border-[#131747]/10 bg-white p-8">
                        <h2 class="text-2xl font-bold text-[#131747]"> General Disclaimer </h2>
                        <p class="mt-4 leading-8 text-[#131747]/70"> The information, content, and calculator results
                            available on MR Calculators are provided for educational and informational purposes only.
                        </p>
                        <p class="mt-4 leading-8 text-[#131747]/70"> While we strive to provide accurate calculations
                            and helpful insights, we do not guarantee the accuracy, completeness, reliability, or
                            suitability of any information or results generated through our platform. </p>
                    </section> <!-- No Professional Advice -->
                    <section class="rounded-3xl border border-[#131747]/10 bg-white p-8">
                        <h2 class="text-2xl font-bold text-[#131747]"> No Professional Advice </h2>
                        <p class="mt-4 leading-8 text-[#131747]/70"> Nothing on this website should be interpreted as
                            financial, accounting, tax, legal, investment, or business consulting advice. </p>
                        <p class="mt-4 leading-8 text-[#131747]/70"> Before making important financial or business
                            decisions, you should consult qualified professionals who understand your specific
                            circumstances. </p>
                    </section> <!-- Calculator Results -->
                    <section class="rounded-3xl border border-[#131747]/10 bg-white p-8">
                        <h2 class="text-2xl font-bold text-[#131747]"> Calculator Results & Estimates </h2>
                        <p class="mt-4 leading-8 text-[#131747]/70"> Calculator outputs are generated using the
                            information entered by users and predefined mathematical formulas. </p>
                        <p class="mt-4 leading-8 text-[#131747]/70"> Results are estimates only and should not be viewed
                            as guarantees of future performance, profits, revenue, customer growth, business success, or
                            financial outcomes. </p>
                        <p class="mt-4 leading-8 text-[#131747]/70"> Actual results may vary significantly due to market
                            conditions, economic changes, competition, customer behavior, operational factors, and other
                            variables beyond our control. </p>
                    </section> <!-- No Guarantees -->
                    <section class="rounded-3xl border border-[#131747]/10 bg-white p-8">
                        <h2 class="text-2xl font-bold text-[#131747]"> No Guarantees </h2>
                        <p class="mt-4 leading-8 text-[#131747]/70"> We do not guarantee: </p>
                        <ul class="mt-6 list-disc space-y-3 pl-6 text-[#131747]/70">
                            <li>Business growth or success</li>
                            <li>Revenue increases</li>
                            <li>Profitability improvements</li>
                            <li>Customer acquisition results</li>
                            <li>Marketing campaign performance</li>
                            <li>Future sales forecasts</li>
                            <li>Investment outcomes</li>
                        </ul>
                    </section> <!-- User Responsibility -->
                    <section class="rounded-3xl border border-[#131747]/10 bg-white p-8">
                        <h2 class="text-2xl font-bold text-[#131747]"> User Responsibility </h2>
                        <p class="mt-4 leading-8 text-[#131747]/70"> You are solely responsible for evaluating and
                            verifying any information obtained from our calculators before relying on it. </p>
                        <p class="mt-4 leading-8 text-[#131747]/70"> Any decisions made based on calculator results are
                            made at your own discretion and risk. </p>
                    </section> <!-- Limitation of Liability -->
                    <section class="rounded-3xl border border-[#131747]/10 bg-white p-8">
                        <h2 class="text-2xl font-bold text-[#131747]"> Limitation of Liability </h2>
                        <p class="mt-4 leading-8 text-[#131747]/70"> To the fullest extent permitted by law, MR
                            Calculators, its owners, affiliates, partners, employees, and service providers shall not be
                            liable for any direct, indirect, incidental, consequential, or special damages resulting
                            from: </p>
                        <ul class="mt-6 list-disc space-y-3 pl-6 text-[#131747]/70">
                            <li>Use of the platform</li>
                            <li>Reliance on calculator results</li>
                            <li>Business or financial decisions made by users</li>
                            <li>Errors, omissions, or interruptions in service</li>
                        </ul>
                    </section> <!-- Changes -->
                    <section class="rounded-3xl border border-[#131747]/10 bg-white p-8">
                        <h2 class="text-2xl font-bold text-[#131747]"> Changes to This Disclaimer </h2>
                        <p class="mt-4 leading-8 text-[#131747]/70"> We may update this Disclaimer at any time to
                            reflect changes to our services, business practices, or legal requirements. </p>
                        <p class="mt-4 leading-8 text-[#131747]/70"> Any updates will be posted on this page along with
                            the revised effective date. </p>
                    </section>
                    <!-- Contact -->
                    <LegalContactCard title="Questions?"
                        description="If you have questions about this Disclaimer, our calculators, or how information is presented on the platform, please contact our support team." />
                </div>
            </div>
        </div>

    </PublicLayout>
</template>