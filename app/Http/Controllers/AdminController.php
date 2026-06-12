<?php

namespace App\Http\Controllers;

use App\Models\CalculatorTool;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use App\Support\CalculatorCatalog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
    public function users(Request $request): Response
    {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:120'],
            'role' => ['nullable', Rule::in(['user', 'admin'])],
            'status' => ['nullable', 'string', 'max:60'],
            'plan' => ['nullable', 'string', 'max:120'],
        ]);

        $users = User::query()
            ->with(['subscriptions.items'])
            ->when($filters['search'] ?? null, function ($query, string $search) {
                $query->where(function ($query) use ($search) {
                    $query
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('company_name', 'like', "%{$search}%");
                });
            })
            ->when($filters['role'] ?? null, fn ($query, string $role) => $query->where('role', $role))
            ->when($filters['status'] ?? null, fn ($query, string $status) => $query->whereHas('subscriptions', fn ($query) => $query->where('stripe_status', $status)))
            ->when($filters['plan'] ?? null, function ($query, string $planSlug) {
                $plan = Plan::query()->where('slug', $planSlug)->first();

                if (! $plan) {
                    return;
                }

                $priceIds = collect([$plan->stripe_price_id_monthly, $plan->stripe_price_id_yearly])->filter()->all();

                $query->whereHas('subscriptions.items', fn ($query) => $query->whereIn('stripe_price', $priceIds));
            })
            ->latest()
            ->paginate(25)
            ->withQueryString();

        return Inertia::render('Admin/Users/Index', [
            'users' => collect($users->items())->map(fn (User $user) => $this->serializeUser($user))->values(),
            'pagination' => [
                'total' => $users->total(),
                'current_page' => $users->currentPage(),
                'last_page' => $users->lastPage(),
                'links' => $users->linkCollection(),
            ],
            'filters' => $filters,
            'plans' => Plan::query()->orderBy('sort_order')->get(['name', 'slug']),
            'statuses' => Subscription::query()->select('stripe_status')->distinct()->pluck('stripe_status')->filter()->values(),
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

        return Inertia::render('Admin/Plans/Index', [
            'plans' => $plans->map(fn (Plan $plan) => $this->serializePlan($plan))->values(),
            'availableFeatures' => CalculatorCatalog::all(),
            'availableTools' => CalculatorTool::query()->active()->orderBy('display_order')->get()->map(fn (CalculatorTool $tool) => $this->serializeTool($tool))->values(),
        ]);
    }

    /**
     * Display the subscriptions log workspace.
     */
    public function subscriptions(Request $request): Response
    {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:120'],
            'status' => ['nullable', 'string', 'max:60'],
            'plan' => ['nullable', 'string', 'max:120'],
        ]);

        $subscriptions = Subscription::query()
            ->with(['user', 'items'])
            ->when($filters['search'] ?? null, function ($query, string $search) {
                $query->where(function ($query) use ($search) {
                    $query
                        ->where('stripe_id', 'like', "%{$search}%")
                        ->orWhereHas('user', fn ($query) => $query
                            ->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%"));
                });
            })
            ->when($filters['status'] ?? null, fn ($query, string $status) => $query->where('stripe_status', $status))
            ->when($filters['plan'] ?? null, function ($query, string $planSlug) {
                $plan = Plan::query()->where('slug', $planSlug)->first();

                if (! $plan) {
                    return;
                }

                $priceIds = collect([$plan->stripe_price_id_monthly, $plan->stripe_price_id_yearly])->filter()->all();

                $query->whereHas('items', fn ($query) => $query->whereIn('stripe_price', $priceIds));
            })
            ->latest()
            ->paginate(25)
            ->withQueryString();

        return Inertia::render('Admin/Subscriptions/Index', [
            'subscriptions' => collect($subscriptions->items())->map(fn (Subscription $subscription) => $this->serializeSubscription($subscription))->values(),
            'pagination' => [
                'total' => $subscriptions->total(),
                'current_page' => $subscriptions->currentPage(),
                'last_page' => $subscriptions->lastPage(),
                'links' => $subscriptions->linkCollection(),
            ],
            'filters' => $filters,
            'plans' => Plan::query()->orderBy('sort_order')->get(['name', 'slug']),
            'statuses' => Subscription::query()->select('stripe_status')->distinct()->pluck('stripe_status')->filter()->values(),
        ]);
    }

    /**
     * Display calculator tool content management.
     */
    public function tools(): Response
    {
        $tools = CalculatorTool::query()
            ->withCount('plans')
            ->orderBy('display_order')
            ->orderBy('id')
            ->get();

        return Inertia::render('Admin/Tools/Index', [
            'tools' => $tools->map(fn (CalculatorTool $tool) => $this->serializeTool($tool, true))->values(),
        ]);
    }

    /**
     * Show the admin user creation page.
     */
    public function createUser(): Response
    {
        return Inertia::render('Admin/Users/Create');
    }

    /**
     * Store a user from the admin workspace.
     */
    public function storeUser(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)],
            'password' => ['required', 'string', 'min:8'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'role' => ['required', Rule::in(['user', 'admin'])],
        ]);

        $user = User::query()->create([
            ...collect($validated)->except(['role'])->all(),
            'password' => Hash::make($validated['password']),
        ]);

        $user->forceFill([
            'role' => $validated['role'],
            'email_verified_at' => now(),
        ])->save();

        return redirect()
            ->route('admin.users.show', $user)
            ->with('success', 'User created successfully.');
    }

    /**
     * Show a user's admin profile.
     */
    public function showUser(User $user): Response
    {
        $user->load(['subscriptions.items']);

        return Inertia::render('Admin/Users/Show', [
            'user' => $this->serializeUser($user),
            'subscriptions' => $user->subscriptions->map(fn (Subscription $subscription) => $this->serializeSubscription($subscription))->values(),
        ]);
    }

    /**
     * Show the user edit form.
     */
    public function editUser(User $user): Response
    {
        return Inertia::render('Admin/Users/Edit', [
            'user' => $this->serializeUser($user),
        ]);
    }

    /**
     * Update high-level user administration settings.
     */
    public function updateUser(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'email' => ['sometimes', 'required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'company_name' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'role' => ['required', Rule::in(['user', 'admin'])],
        ]);

        $user->forceFill(collect($validated)->only([
            'name',
            'email',
            'company_name',
            'phone',
            'role',
        ])->all())->save();

        return redirect()
            ->back()
            ->with('success', 'User permissions have been updated.');
    }

    /**
     * Show the plan creation page.
     */
    public function createPlan(): Response
    {
        return Inertia::render('Admin/Plans/Create', $this->planFormProps());
    }

    /**
     * Create a subscription plan.
     */
    public function storePlan(Request $request): RedirectResponse
    {
        $payload = $this->validatedPlanPayload($request);

        Plan::query()->create($payload);
        $plan = Plan::query()->where('slug', $payload['slug'])->first();

        if ($plan) {
            $this->syncPlanTools($plan, $request->input('tool_access', []));
        }

        return redirect()
            ->route('admin.plans.show', $plan)
            ->with('success', 'Plan created successfully.');
    }

    /**
     * Show a subscription plan.
     */
    public function showPlan(Plan $plan): Response
    {
        $plan->load('calculatorTools');

        return Inertia::render('Admin/Plans/Show', [
            'plan' => $this->serializePlan($plan),
            'tools' => $plan->calculatorTools->map(fn (CalculatorTool $tool) => $this->serializeTool($tool))->values(),
        ]);
    }

    /**
     * Show the plan edit page.
     */
    public function editPlan(Plan $plan): Response
    {
        return Inertia::render('Admin/Plans/Edit', [
            ...$this->planFormProps(),
            'plan' => $this->serializePlan($plan),
        ]);
    }

    /**
     * Update a subscription plan.
     */
    public function updatePlan(Request $request, Plan $plan): RedirectResponse
    {
        $payload = $this->validatedPlanPayload($request, $plan);

        $plan->update($payload);
        $this->syncPlanTools($plan, $request->input('tool_access', []));

        return redirect()
            ->route('admin.plans.index')
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
            'tool_access' => ['nullable', 'array'],
            'tool_access.*' => ['string', Rule::exists(CalculatorTool::class, 'slug')],
        ]);

        $toolAccess = $validated['tool_access'] ?? [];
        $featureAccess = array_values(array_unique([
            ...($validated['feature_access'] ?? []),
            ...$toolAccess,
        ]));

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
            'feature_access' => $featureAccess,
        ];
    }

    /**
     * Create a calculator tool.
     */
    public function storeTool(Request $request): RedirectResponse
    {
        $tool = CalculatorTool::query()->create($this->validatedToolPayload($request));

        return redirect()
            ->route('admin.tools.show', $tool)
            ->with('success', 'Tool created successfully.');
    }

    /**
     * Show the tool creation page.
     */
    public function createTool(): Response
    {
        return Inertia::render('Admin/Tools/Create');
    }

    /**
     * Show a calculator tool.
     */
    public function showTool(CalculatorTool $tool): Response
    {
        $tool->load('plans');

        return Inertia::render('Admin/Tools/Show', [
            'tool' => $this->serializeTool($tool, true),
            'plans' => $tool->plans->map(fn (Plan $plan) => $this->serializePlan($plan))->values(),
        ]);
    }

    /**
     * Show the calculator tool edit page.
     */
    public function editTool(CalculatorTool $tool): Response
    {
        return Inertia::render('Admin/Tools/Edit', [
            'tool' => $this->serializeTool($tool, true),
        ]);
    }

    /**
     * Show a subscription record.
     */
    public function showSubscription(Subscription $subscription): Response
    {
        $subscription->load(['user', 'items']);

        return Inertia::render('Admin/Subscriptions/Show', [
            'subscription' => $this->serializeSubscription($subscription),
        ]);
    }

    /**
     * Update calculator tool content and visibility.
     */
    public function updateTool(Request $request, CalculatorTool $tool): RedirectResponse
    {
        $tool->update($this->validatedToolPayload($request, $tool));

        return redirect()
            ->route('admin.tools.index')
            ->with('success', 'Tool updated successfully.');
    }

    /**
     * Validate and normalize calculator tool data.
     *
     * @return array<string, mixed>
     */
    private function validatedToolPayload(Request $request, ?CalculatorTool $tool = null): array
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:160'],
            'slug' => ['required', 'string', 'max:120', Rule::unique(CalculatorTool::class)->ignore($tool?->id)],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'short_description' => ['nullable', 'string', 'max:500'],
            'icon' => ['required', 'string', 'max:80'],
            'route' => ['nullable', 'string', 'max:160'],
            'category' => ['nullable', 'string', 'max:120'],
            'tag' => ['nullable', 'string', 'max:80'],
            'badge' => ['nullable', 'string', 'max:80'],
            'is_active' => ['nullable', 'boolean'],
            'is_featured' => ['nullable', 'boolean'],
            'is_recommended' => ['nullable', 'boolean'],
            'is_coming_soon' => ['nullable', 'boolean'],
            'requires_subscription' => ['nullable', 'boolean'],
            'display_order' => ['nullable', 'integer', 'min:0'],
            'show_on_dashboard' => ['nullable', 'boolean'],
            'show_on_homepage' => ['nullable', 'boolean'],
            'content_json' => ['nullable', 'json'],
        ]);

        return [
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'subtitle' => $validated['subtitle'] ?? null,
            'description' => $validated['description'] ?? null,
            'short_description' => $validated['short_description'] ?? null,
            'icon' => $validated['icon'],
            'route' => $validated['route'] ?? null,
            'category' => $validated['category'] ?? null,
            'tag' => $validated['tag'] ?? null,
            'badge' => $validated['badge'] ?? null,
            'is_active' => (bool) ($validated['is_active'] ?? false),
            'is_featured' => (bool) ($validated['is_featured'] ?? false),
            'is_recommended' => (bool) ($validated['is_recommended'] ?? false),
            'is_coming_soon' => (bool) ($validated['is_coming_soon'] ?? false),
            'requires_subscription' => (bool) ($validated['requires_subscription'] ?? true),
            'display_order' => $validated['display_order'] ?? 0,
            'show_on_dashboard' => (bool) ($validated['show_on_dashboard'] ?? true),
            'show_on_homepage' => (bool) ($validated['show_on_homepage'] ?? true),
            'content' => json_decode($validated['content_json'] ?? '{}', true) ?: [],
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
            'tool_access' => $plan->relationLoaded('calculatorTools')
                ? $plan->calculatorTools->pluck('slug')->values()->all()
                : $plan->calculatorTools()->pluck('slug')->values()->all(),
        ];
    }

    /**
     * Common props for plan create/edit pages.
     *
     * @return array<string, mixed>
     */
    private function planFormProps(): array
    {
        return [
            'availableFeatures' => CalculatorCatalog::all(),
            'availableTools' => CalculatorTool::query()
                ->active()
                ->orderBy('display_order')
                ->get()
                ->map(fn (CalculatorTool $tool) => $this->serializeTool($tool))
                ->values(),
        ];
    }

    /**
     * Serialize a calculator tool for admin forms.
     *
     * @return array<string, mixed>
     */
    private function serializeTool(CalculatorTool $tool, bool $includeContent = false): array
    {
        $payload = [
            'id' => $tool->id,
            'slug' => $tool->slug,
            'title' => $tool->title,
            'subtitle' => $tool->subtitle,
            'description' => $tool->description,
            'short_description' => $tool->short_description,
            'icon' => $tool->icon,
            'route' => $tool->route,
            'category' => $tool->category,
            'tag' => $tool->tag,
            'badge' => $tool->badge,
            'is_active' => $tool->is_active,
            'is_featured' => $tool->is_featured,
            'is_recommended' => $tool->is_recommended,
            'is_coming_soon' => $tool->is_coming_soon,
            'requires_subscription' => $tool->requires_subscription,
            'display_order' => $tool->display_order,
            'show_on_dashboard' => $tool->show_on_dashboard,
            'show_on_homepage' => $tool->show_on_homepage,
            'plans_count' => $tool->plans_count ?? null,
        ];

        if ($includeContent) {
            $payload['content_json'] = json_encode($tool->content ?? [], JSON_PRETTY_PRINT);
        }

        return $payload;
    }

    /**
     * Sync plan-tool entitlements and mirror feature_access.
     *
     * @param  array<int, string>  $toolSlugs
     */
    private function syncPlanTools(Plan $plan, array $toolSlugs): void
    {
        $toolIds = CalculatorTool::query()
            ->whereIn('slug', $toolSlugs)
            ->pluck('id')
            ->all();

        $plan->calculatorTools()->sync($toolIds);

        $workspaceFeatures = collect($plan->feature_access ?? [])
            ->reject(fn (string $slug) => CalculatorTool::query()->where('slug', $slug)->exists())
            ->values()
            ->all();

        $plan->forceFill([
            'feature_access' => array_values(array_unique([...$toolSlugs, ...$workspaceFeatures])),
        ])->save();
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
