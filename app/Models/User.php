<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Support\CalculatorCatalog;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Cashier\Billable;

#[Fillable([
    'name',
    'email',
    'password',
    'company_name',
    'phone',
    'billing_address_line1',
    'billing_address_line2',
    'billing_city',
    'billing_state',
    'billing_postal_code',
    'billing_country',
    'last_login_at',
    'last_login_ip',
])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use Billable, HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Determine if the user can access the admin workspace.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Get the calculator history records for the user.
     */
    public function calculatorHistories(): HasMany
    {
        return $this->hasMany(CalculatorHistory::class);
    }

    /**
     * Get the local subscription plan represented by the user's active subscription.
     */
    public function currentPlan(): ?Plan
    {
        $subscription = $this->subscription('default');

        if (! $subscription || ! $subscription->valid()) {
            return null;
        }

        foreach ($subscription->currentPriceIds() as $priceId) {
            $plan = Plan::resolveForPriceId($priceId);

            if ($plan) {
                $plan->loadMissing('calculatorTools');

                return $plan;
            }
        }

        return null;
    }

    /**
     * Get the active billing interval represented by the user's subscription.
     */
    public function currentPlanInterval(): ?string
    {
        $subscription = $this->subscription('default');

        return $subscription?->interval();
    }

    /**
     * Determine if the user has access to a feature flag.
     */
    public function hasFeatureAccess(string $feature): bool
    {
        if ($this->isAdmin()) {
            return true;
        }

        return $this->currentPlan()?->supportsFeature($feature) ?? false;
    }

    /**
     * Build a summary of the user's billing and entitlement state.
     *
     * @return array<string, mixed>
     */
    public function billingSummary(): array
    {
        $subscription = $this->subscription('default');
        $plan = $this->currentPlan();

        return [
            'has_active_subscription' => (bool) $subscription?->valid(),
            'status' => $this->isAdmin() ? 'admin' : ($subscription?->stripe_status ?? 'inactive'),
            'plan_name' => $this->isAdmin() ? 'Administrator' : ($plan?->name ?? 'No active plan'),
            'plan_slug' => $plan?->slug,
            'interval' => $this->currentPlanInterval(),
            'on_grace_period' => (bool) $subscription?->onGracePeriod(),
            'ends_at' => optional($subscription?->ends_at)->toIso8601String(),
            'trial_ends_at' => optional($subscription?->trial_ends_at ?? $this->trial_ends_at)->toIso8601String(),
            'payment_method' => $this->pm_type,
            'payment_method_last_four' => $this->pm_last_four,
            'feature_access' => $this->isAdmin()
                ? CalculatorCatalog::featureSlugs()
                : ($plan?->calculatorTools?->pluck('slug')->values()->all() ?? $plan?->feature_access ?? []),
        ];
    }

    /**
     * Get the user's initials for profile and avatar UI.
     */
    protected function initials(): Attribute
    {
        return Attribute::make(
            get: fn () => Str::of($this->name)
                ->explode(' ')
                ->filter()
                ->take(2)
                ->map(fn (string $segment) => Str::upper(Str::substr($segment, 0, 1)))
                ->implode(''),
        );
    }
}
