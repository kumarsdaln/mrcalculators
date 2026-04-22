<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = usePage().props.auth.user;

const form = useForm({
    name: user.name,
    company_name: user.company_name ?? '',
    phone: user.phone ?? '',
    email: user.email,
    billing_address_line1: user.billing_address_line1 ?? '',
    billing_address_line2: user.billing_address_line2 ?? '',
    billing_city: user.billing_city ?? '',
    billing_state: user.billing_state ?? '',
    billing_postal_code: user.billing_postal_code ?? '',
    billing_country: user.billing_country ?? '',
});
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-semibold text-[#131747]">
                Profile Information
            </h2>

            <p class="mt-2 text-sm leading-6 text-[#131747]/70">
                Keep your account, contact details, and billing address up to date so subscriptions, invoices, and notifications stay in sync.
            </p>
        </header>

        <form
            @submit.prevent="form.patch(route('profile.update'))"
            class="mt-6 space-y-6"
        >
            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <InputLabel for="name" value="Full Name" />

                    <TextInput
                        id="name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.name"
                        required
                        autofocus
                        autocomplete="name"
                    />

                    <InputError class="mt-2" :message="form.errors.name" />
                </div>

                <div>
                    <InputLabel for="company_name" value="Company" />

                    <TextInput
                        id="company_name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.company_name"
                        autocomplete="organization"
                    />

                    <InputError class="mt-2" :message="form.errors.company_name" />
                </div>

                <div>
                    <InputLabel for="email" value="Email" />

                    <TextInput
                        id="email"
                        type="email"
                        class="mt-1 block w-full"
                        v-model="form.email"
                        required
                        autocomplete="username"
                    />

                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <div>
                    <InputLabel for="phone" value="Phone" />

                    <TextInput
                        id="phone"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.phone"
                        autocomplete="tel"
                    />

                    <InputError class="mt-2" :message="form.errors.phone" />
                </div>
            </div>

            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <p class="rounded-2xl border border-[#FF4040]/20 bg-[#FF4040]/8 px-4 py-3 text-sm text-[#131747]">
                    Your email address is unverified.
                    <Link
                        :href="route('verification.send')"
                        method="post"
                        as="button"
                        class="font-semibold text-[#FF4040] transition hover:text-[#131747]"
                    >
                        Click here to re-send the verification email.
                    </Link>
                </p>

                <div
                    v-show="status === 'verification-link-sent'"
                    class="mt-3 rounded-2xl border border-[#131747]/10 bg-[#131747]/5 px-4 py-3 text-sm font-medium text-[#131747]"
                >
                    A new verification link has been sent to your email address.
                </div>
            </div>

            <div class="rounded-[1.5rem] border border-[#131747]/10 bg-[#131747]/5 p-5">
                <div class="mb-4">
                    <h3 class="text-sm font-semibold uppercase tracking-[0.24em] text-[#131747]/55">
                        Billing Address
                    </h3>
                    <p class="mt-2 text-sm text-[#131747]/65">
                        This helps keep invoice and tax details aligned once Stripe billing is configured.
                    </p>
                </div>

                <div class="grid gap-5 md:grid-cols-2">
                    <div class="md:col-span-2">
                        <InputLabel for="billing_address_line1" value="Address Line 1" />
                        <TextInput id="billing_address_line1" type="text" class="mt-1 block w-full" v-model="form.billing_address_line1" autocomplete="address-line1" />
                        <InputError class="mt-2" :message="form.errors.billing_address_line1" />
                    </div>

                    <div class="md:col-span-2">
                        <InputLabel for="billing_address_line2" value="Address Line 2" />
                        <TextInput id="billing_address_line2" type="text" class="mt-1 block w-full" v-model="form.billing_address_line2" autocomplete="address-line2" />
                        <InputError class="mt-2" :message="form.errors.billing_address_line2" />
                    </div>

                    <div>
                        <InputLabel for="billing_city" value="City" />
                        <TextInput id="billing_city" type="text" class="mt-1 block w-full" v-model="form.billing_city" autocomplete="address-level2" />
                        <InputError class="mt-2" :message="form.errors.billing_city" />
                    </div>

                    <div>
                        <InputLabel for="billing_state" value="State / Region" />
                        <TextInput id="billing_state" type="text" class="mt-1 block w-full" v-model="form.billing_state" autocomplete="address-level1" />
                        <InputError class="mt-2" :message="form.errors.billing_state" />
                    </div>

                    <div>
                        <InputLabel for="billing_postal_code" value="Postal Code" />
                        <TextInput id="billing_postal_code" type="text" class="mt-1 block w-full" v-model="form.billing_postal_code" autocomplete="postal-code" />
                        <InputError class="mt-2" :message="form.errors.billing_postal_code" />
                    </div>

                    <div>
                        <InputLabel for="billing_country" value="Country Code" />
                        <TextInput id="billing_country" type="text" class="mt-1 block w-full uppercase" v-model="form.billing_country" autocomplete="country" maxlength="2" placeholder="US" />
                        <InputError class="mt-2" :message="form.errors.billing_country" />
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p
                        v-if="form.recentlySuccessful"
                        class="text-sm font-medium text-[#131747]/65"
                    >
                        Saved.
                    </p>
                </Transition>
            </div>
        </form>
    </section>
</template>
