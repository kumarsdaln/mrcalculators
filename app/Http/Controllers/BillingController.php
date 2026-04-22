<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\User;
use App\Support\CalculatorCatalog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Laravel\Cashier\Invoice;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Throwable;

class BillingController extends Controller
{
    /**
     * Display the subscription and billing center.
     */
    public function index(Request $request): Response
    {
        $user = $request->user();

        return Inertia::render('Billing/Index', [
            'plans' => Plan::query()
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get()
                ->map(fn (Plan $plan) => $this->serializePlan($plan, $user))
                ->values(),
            'subscription' => $user->billingSummary(),
            'currentPlan' => $user->currentPlan()
                ? $this->serializePlan($user->currentPlan(), $user)
                : null,
            'features' => CalculatorCatalog::all(),
            'stripeConfigured' => $this->stripeConfigured(),
            'invoices' => $this->serializeInvoices($user),
        ]);
    }

    /**
     * Start a Stripe Checkout session for a subscription plan.
     */
    public function checkout(Request $request, Plan $plan, string $interval): SymfonyResponse
    {
        $user = $request->user();
        $interval = $interval === 'yearly' ? 'yearly' : 'monthly';

        if (! $this->stripeConfigured()) {
            return redirect()
                ->route('billing.index')
                ->with('error', 'Stripe billing is not configured yet. Add your Stripe keys and price IDs first.');
        }

        if (! $plan->is_active) {
            return redirect()
                ->route('billing.index')
                ->with('error', 'That plan is currently unavailable.');
        }

        $priceId = $plan->getPriceId($interval);

        if (! filled($priceId)) {
            return redirect()
                ->route('billing.index')
                ->with('error', 'This plan does not have a Stripe price configured for the selected billing interval.');
        }

        if ($user->subscription('default')?->active()) {
            return redirect()
                ->route('billing.index')
                ->with('error', 'You already have an active subscription. Use the billing portal to change or cancel your plan.');
        }

        try {
            $subscription = $user
                ->newSubscription('default', $priceId)
                ->allowPromotionCodes()
                ->collectTaxIds();

            if ($plan->trial_days > 0) {
                $subscription->trialDays($plan->trial_days);
            }

            return $subscription->checkout([
                'success_url' => route('billing.success'),
                'cancel_url' => route('billing.cancelled'),
                'metadata' => [
                    'plan_slug' => $plan->slug,
                    'billing_interval' => $interval,
                ],
            ], [
                'name' => $user->name,
                'email' => $user->email,
            ]);
        } catch (Throwable $exception) {
            report($exception);

            return redirect()
                ->route('billing.index')
                ->with('error', 'We could not start Stripe checkout. Please confirm your keys, webhook, and plan price IDs.');
        }
    }

    /**
     * Redirect the user to the Stripe billing portal.
     */
    public function portal(Request $request): RedirectResponse
    {
        if (! $this->stripeConfigured()) {
            return redirect()
                ->route('billing.index')
                ->with('error', 'Stripe billing is not configured yet.');
        }

        if (! filled($request->user()->stripe_id)) {
            return redirect()
                ->route('billing.index')
                ->with('error', 'Create a subscription first before opening the billing portal.');
        }

        return $request->user()->redirectToBillingPortal(route('billing.index'));
    }

    /**
     * Cancel the user's active subscription at period end.
     */
    public function cancel(Request $request): RedirectResponse
    {
        $subscription = $request->user()->subscription('default');

        if (! $subscription || ! $subscription->active()) {
            return redirect()
                ->route('billing.index')
                ->with('error', 'There is no active subscription to cancel.');
        }

        $subscription->cancel();

        return redirect()
            ->route('billing.index')
            ->with('success', 'Your subscription will remain active until the end of the current billing period.');
    }

    /**
     * Resume a subscription that is still on grace period.
     */
    public function resume(Request $request): RedirectResponse
    {
        $subscription = $request->user()->subscription('default');

        if (! $subscription || ! $subscription->onGracePeriod()) {
            return redirect()
                ->route('billing.index')
                ->with('error', 'There is no subscription on grace period to resume.');
        }

        $subscription->resume();

        return redirect()
            ->route('billing.index')
            ->with('success', 'Your subscription has been resumed.');
    }

    /**
     * Handle the post-checkout success redirect.
     */
    public function success(): RedirectResponse
    {
        return redirect()
            ->route('billing.index')
            ->with('success', 'Checkout completed. Stripe may take a few moments to confirm the subscription via webhook.');
    }

    /**
     * Handle the post-checkout cancellation redirect.
     */
    public function cancelled(): RedirectResponse
    {
        return redirect()
            ->route('billing.index')
            ->with('error', 'Checkout was cancelled before the subscription was created.');
    }

    /**
     * Serialize a plan for Inertia responses.
     *
     * @return array<string, mixed>
     */
    private function serializePlan(Plan $plan, User $user): array
    {
        $currentPlan = $user->currentPlan();

        return [
            'id' => $plan->id,
            'name' => $plan->name,
            'slug' => $plan->slug,
            'description' => $plan->description,
            'currency' => strtoupper($plan->currency),
            'monthly_price' => filled($plan->monthly_price) ? $plan->monthly_price / 100 : null,
            'yearly_price' => filled($plan->yearly_price) ? $plan->yearly_price / 100 : null,
            'monthly_price_display' => $plan->formattedAmount('monthly'),
            'yearly_price_display' => $plan->formattedAmount('yearly'),
            'trial_days' => $plan->trial_days,
            'is_active' => $plan->is_active,
            'is_featured' => $plan->is_featured,
            'feature_access' => $plan->feature_access ?? [],
            'intervals' => $plan->intervalOptions(),
            'is_current' => $currentPlan?->is($plan) ?? false,
            'checkout_ready' => [
                'monthly' => filled($plan->stripe_price_id_monthly),
                'yearly' => filled($plan->stripe_price_id_yearly),
            ],
        ];
    }

    /**
     * Serialize the user's recent invoices.
     *
     * @return array<int, array<string, mixed>>
     */
    private function serializeInvoices(User $user): array
    {
        if (! $this->stripeConfigured() || ! filled($user->stripe_id)) {
            return [];
        }

        try {
            return collect($user->invoices())
                ->take(8)
                ->map(function (Invoice $invoice) {
                    $stripeInvoice = $invoice->asStripeInvoice();

                    return [
                        'id' => $stripeInvoice->id,
                        'total' => $invoice->total(),
                        'status' => $stripeInvoice->status,
                        'date' => $invoice->date()->toIso8601String(),
                        'hosted_invoice_url' => $stripeInvoice->hosted_invoice_url,
                        'invoice_pdf' => $stripeInvoice->invoice_pdf,
                    ];
                })
                ->values()
                ->all();
        } catch (Throwable $exception) {
            report($exception);

            return [];
        }
    }

    /**
     * Determine if Stripe billing is configured.
     */
    private function stripeConfigured(): bool
    {
        return filled(config('cashier.key')) && filled(config('cashier.secret'));
    }
}
