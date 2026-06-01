<script setup>
    import LegalContactCard from '@/Components/LegalContactCard.vue';
    import PublicLayout from '@/Layouts/PublicLayout.vue';
    defineProps({
        canLogin: Boolean,
        canRegister: Boolean,
    });
</script>

<template>

    <PublicLayout :can-login="canLogin" :can-register="canRegister" title="Terms & Conditions">

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
                            Terms & Conditions
                        </div>

                        <h1 class="mt-6 text-4xl md:text-6xl font-black tracking-tight">
                            Terms of Use
                        </h1>

                        <p class="mt-6 text-lg leading-relaxed text-white/70 max-w-3xl">
                            These terms explain how our platform works, your
                            responsibilities as a user, and the rules that
                            govern access to our calculators and services.
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
                            Acceptance of Terms
                        </h2>

                        <p class="mt-4 text-[#131747]/70 leading-8">
                            By accessing or using Martha Razo Financial
                            Calculators, you agree to comply with and be bound
                            by these Terms and Conditions.
                        </p>
                    </section>

                    <section class="bg-white rounded-3xl border border-[#131747]/10 p-8">
                        <h2 class="text-2xl font-bold text-[#131747]">
                            Our Services
                        </h2>

                        <p class="mt-4 text-[#131747]/70 leading-8">
                            Our platform provides calculators, forecasting
                            tools, pricing analysis tools, business planning
                            resources, and related services designed to support
                            informed business decision-making.
                        </p>
                    </section>

                    <section class="bg-white rounded-3xl border border-[#131747]/10 p-8">
                        <h2 class="text-2xl font-bold text-[#131747]">
                            No Professional Advice
                        </h2>

                        <p class="mt-4 text-[#131747]/70 leading-8">
                            Calculator results are provided for informational
                            purposes only and should not be considered legal,
                            tax, accounting, financial, or investment advice.
                        </p>

                        <p class="mt-4 text-[#131747]/70 leading-8">
                            Always consult qualified professionals before making
                            important business or financial decisions.
                        </p>
                    </section>

                    <section class="bg-white rounded-3xl border border-[#131747]/10 p-8">
                        <h2 class="text-2xl font-bold text-[#131747]">
                            User Responsibilities
                        </h2>

                        <ul class="mt-6 list-disc pl-6 space-y-3 text-[#131747]/70 leading-8">
                            <li>Provide accurate information.</li>
                            <li>Maintain account security.</li>
                            <li>Use the platform lawfully.</li>
                            <li>Respect intellectual property rights.</li>
                            <li>Avoid attempts to disrupt platform operations.</li>
                        </ul>
                    </section>

                    <section class="bg-white rounded-3xl border border-[#131747]/10 p-8">
                        <h2 class="text-2xl font-bold text-[#131747]">
                            Subscriptions & Billing
                        </h2>

                        <p class="mt-4 text-[#131747]/70 leading-8">
                            Certain calculators and features may require a paid
                            subscription. Subscription plans, pricing, and
                            available features may change over time.
                        </p>

                        <p class="mt-4 text-[#131747]/70 leading-8">
                            By purchasing a subscription, you authorize payment
                            processing according to your selected plan.
                        </p>
                    </section>

                    <section class="bg-white rounded-3xl border border-[#131747]/10 p-8">
                        <h2 class="text-2xl font-bold text-[#131747]">
                            Intellectual Property
                        </h2>

                        <p class="mt-4 text-[#131747]/70 leading-8">
                            All content, software, branding, calculators,
                            designs, graphics, and intellectual property
                            displayed on this platform remain the property of
                            Martha Razo Financial Calculators unless otherwise
                            stated.
                        </p>
                    </section>

                    <section class="bg-white rounded-3xl border border-[#131747]/10 p-8">
                        <h2 class="text-2xl font-bold text-[#131747]">
                            Prohibited Activities
                        </h2>

                        <ul class="mt-6 list-disc pl-6 space-y-3 text-[#131747]/70 leading-8">
                            <li>Attempting unauthorized access.</li>
                            <li>Reverse engineering platform functionality.</li>
                            <li>Distributing malicious software.</li>
                            <li>Using automated tools to abuse services.</li>
                            <li>Violating applicable laws or regulations.</li>
                        </ul>
                    </section>

                    <section class="bg-white rounded-3xl border border-[#131747]/10 p-8">
                        <h2 class="text-2xl font-bold text-[#131747]">
                            Limitation of Liability
                        </h2>

                        <p class="mt-4 text-[#131747]/70 leading-8">
                            To the fullest extent permitted by law, we shall not
                            be liable for any indirect, incidental, special,
                            consequential, or punitive damages arising from your
                            use of the platform.
                        </p>

                        <p class="mt-4 text-[#131747]/70 leading-8">
                            Users remain responsible for decisions made based on
                            calculator results and information provided through
                            the platform.
                        </p>
                    </section>

                    <section class="bg-white rounded-3xl border border-[#131747]/10 p-8">
                        <h2 class="text-2xl font-bold text-[#131747]">
                            Termination
                        </h2>

                        <p class="mt-4 text-[#131747]/70 leading-8">
                            We reserve the right to suspend or terminate access
                            to our services if these Terms are violated or if
                            misuse of the platform is detected.
                        </p>
                    </section>

                    <section class="bg-white rounded-3xl border border-[#131747]/10 p-8">
                        <h2 class="text-2xl font-bold text-[#131747]">
                            Changes to These Terms
                        </h2>

                        <p class="mt-4 text-[#131747]/70 leading-8">
                            We may update these Terms and Conditions from time
                            to time. Any changes will be posted on this page
                            with an updated revision date.
                        </p>
                    </section>

                    <!-- Contact -->
                    <LegalContactCard title="Need Clarification?"
                        description="If you have questions regarding our Terms & Conditions, subscriptions, billing, or platform usage, our team is here to help." />

                </div>

            </div>
        </div>

    </PublicLayout>
</template>