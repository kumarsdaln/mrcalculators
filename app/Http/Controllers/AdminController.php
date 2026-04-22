<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use App\Support\CalculatorCatalog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard stats workspace.
     */
    public function dashboard(): Response
    {
        $activeSubscriptions = Subscription::query()
            ->with('items')
            ->active()
            ->get();

        $mrrEstimate = $activeSubscriptions->sum(function (Subscription $subscription) {
            $plan = $subscription->plan();
            $interval = $subscription->interval() ?? 'monthly';

            return $plan?->monthlyEquivalentAmount($interval) ?? 0;
        });

        return Inertia::render('Admin/Dashboard', [
            'stats' => [
                'users' => User::query()->count(),
                'admins' => User::query()->where('role', 'admin')->count(),
                'active_subscribers' => Subscription::query()->active()->count(),
                'past_due_subscribers' => Subscription::query()->pastDue()->count(),
                'active_plans' => Plan::query()->active()->count(),
                'mrr_estimate' => '$'.number_format($mrrEstimate / 100, 2),
            ],
            'stripeConfigured' => filled(config('cashier.key')) && filled(config('cashier.secret')),
        ]);
    }

    /**
     * Display the users management workspace.
     */
    public function users(): Response
    {
        $users = User::query()
            ->with(['subscriptions.items'])
            ->latest()
            ->paginate(50); // Using simple pagination to handle large datasets

        return Inertia::render('Admin/Users', [
            'users' => collect($users->items())->map(fn (User $user) => $this->serializeUser($user))->values(),
            'pagination' => [
                'total' => $users->total(),
                'current_page' => $users->currentPage(),
                'last_page' => $users->lastPage(),
            ],
        ]);
    }

    /**
     * Display the plans management workspace.
     */
    public function plans(): Response
    {
        $plans = Plan::query()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return Inertia::render('Admin/Plans', [
            'plans' => $plans->map(fn (Plan $plan) => $this->serializePlan($plan))->values(),
            'availableFeatures' => CalculatorCatalog::all(),
        ]);
    }

    /**
     * Display the subscriptions log workspace.
     */
    public function subscriptions(): Response
    {
        $subscriptions = Subscription::query()
            ->with(['user', 'items'])
            ->latest()
            ->paginate(50);

        return Inertia::render('Admin/Subscriptions', [
            'subscriptions' => collect($subscriptions->items())->map(fn (Subscription $subscription) => $this->serializeSubscription($subscription))->values(),
            'pagination' => [
                'total' => $subscriptions->total(),
                'current_page' => $subscriptions->currentPage(),
                'last_page' => $subscriptions->lastPage(),
            ],
        ]);
    }

    /**
     * Update high-level user administration settings.
     */
    public function updateUser(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'role' => ['required', Rule::in(['user', 'admin'])],
        ]);

        $user->forceFill([
            'role' => $validated['role'],
        ])->save();

        return redirect()
            ->back()
            ->with('success', 'User permissions have been updated.');
    }

    /**
     * Create a subscription plan.
     */
    public function storePlan(Request $request): RedirectResponse
    {
        $payload = $this->validatedPlanPayload($request);

        Plan::query()->create($payload);

        return redirect()
            ->route('admin.plans')
            ->with('success', 'Plan created successfully.');
    }

    /**
     * Update a subscription plan.
     */
    public function updatePlan(Request $request, Plan $plan): RedirectResponse
    {
        $payload = $this->validatedPlanPayload($request, $plan);

        $plan->update($payload);

        return redirect()
            ->route('admin.plans')
            ->with('success', 'Plan updated successfully.');
    }

    /**
     * Validate and normalize plan data from the admin panel.
     *
     * @return array<string, mixed>
     */
    private function validatedPlanPayload(Request $request, ?Plan $plan = null): array
    {
        $featureSlugs = CalculatorCatalog::featureSlugs();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'slug' => ['required', 'string', 'max:120', Rule::unique(Plan::class)->ignore($plan?->id)],
            'description' => ['nullable', 'string', 'max:1000'],
            'stripe_product_id' => ['nullable', 'string', 'max:255'],
            'stripe_price_id_monthly' => ['nullable', 'string', 'max:255'],
            'stripe_price_id_yearly' => ['nullable', 'string', 'max:255'],
            'monthly_price' => ['nullable', 'numeric', 'min:0'],
            'yearly_price' => ['nullable', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'size:3'],
            'trial_days' => ['nullable', 'integer', 'min:0', 'max:90'],
            'is_active' => ['nullable', 'boolean'],
            'is_featured' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'feature_access' => ['nullable', 'array'],
            'feature_access.*' => ['string', Rule::in($featureSlugs)],
        ]);

        return [
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'description' => $validated['description'] ?? null,
            'stripe_product_id' => $validated['stripe_product_id'] ?? null,
            'stripe_price_id_monthly' => $validated['stripe_price_id_monthly'] ?? null,
            'stripe_price_id_yearly' => $validated['stripe_price_id_yearly'] ?? null,
            'monthly_price' => isset($validated['monthly_price']) ? (int) round($validated['monthly_price'] * 100) : null,
            'yearly_price' => isset($validated['yearly_price']) ? (int) round($validated['yearly_price'] * 100) : null,
            'currency' => strtolower($validated['currency']),
            'trial_days' => $validated['trial_days'] ?? 0,
            'is_active' => (bool) ($validated['is_active'] ?? false),
            'is_featured' => (bool) ($validated['is_featured'] ?? false),
            'sort_order' => $validated['sort_order'] ?? 0,
            'feature_access' => array_values(array_unique($validated['feature_access'] ?? [])),
        ];
    }

    /**
     * Serialize a plan for Inertia responses.
     *
     * @return array<string, mixed>
     */
    private function serializePlan(Plan $plan): array
    {
        return [
            'id' => $plan->id,
            'name' => $plan->name,
            'slug' => $plan->slug,
            'description' => $plan->description,
            'monthly_price' => filled($plan->monthly_price) ? $plan->monthly_price / 100 : null,
            'yearly_price' => filled($plan->yearly_price) ? $plan->yearly_price / 100 : null,
            'monthly_price_display' => $plan->formattedAmount('monthly'),
            'yearly_price_display' => $plan->formattedAmount('yearly'),
            'currency' => strtoupper($plan->currency),
            'trial_days' => $plan->trial_days,
            'is_active' => $plan->is_active,
            'is_featured' => $plan->is_featured,
            'sort_order' => $plan->sort_order,
            'stripe_product_id' => $plan->stripe_product_id,
            'stripe_price_id_monthly' => $plan->stripe_price_id_monthly,
            'stripe_price_id_yearly' => $plan->stripe_price_id_yearly,
            'feature_access' => $plan->feature_access ?? [],
        ];
    }

    /**
     * Serialize a user for the admin workspace.
     *
     * @return array<string, mixed>
     */
    private function serializeUser(User $user): array
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'company_name' => $user->company_name,
            'phone' => $user->phone,
            'role' => $user->role,
            'created_at' => optional($user->created_at)->toIso8601String(),
            'last_login_at' => optional($user->last_login_at)->toIso8601String(),
            'subscription' => $user->billingSummary(),
        ];
    }

    /**
     * Serialize a subscription for the admin workspace.
     *
     * @return array<string, mixed>
     */
    private function serializeSubscription(Subscription $subscription): array
    {
        $plan = $subscription->plan();

        return [
            'id' => $subscription->id,
            'type' => $subscription->type,
            'status' => $subscription->stripe_status,
            'plan' => $plan?->name,
            'plan_slug' => $plan?->slug,
            'interval' => $subscription->interval(),
            'price_ids' => $subscription->currentPriceIds(),
            'trial_ends_at' => optional($subscription->trial_ends_at)->toIso8601String(),
            'ends_at' => optional($subscription->ends_at)->toIso8601String(),
            'created_at' => optional($subscription->created_at)->toIso8601String(),
            'user' => [
                'id' => $subscription->user?->id,
                'name' => $subscription->user?->name,
                'email' => $subscription->user?->email,
            ],
        ];
    }
}
