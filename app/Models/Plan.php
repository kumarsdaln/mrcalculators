<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Schema;

#[Fillable([
    'name',
    'slug',
    'description',
    'stripe_product_id',
    'stripe_price_id_monthly',
    'stripe_price_id_yearly',
    'monthly_price',
    'yearly_price',
    'currency',
    'trial_days',
    'is_active',
    'is_featured',
    'sort_order',
    'feature_access',
    'feature_limits',
    'metadata',
])]
class Plan extends Model
{
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'monthly_price' => 'integer',
            'yearly_price' => 'integer',
            'trial_days' => 'integer',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'sort_order' => 'integer',
            'feature_access' => 'array',
            'feature_limits' => 'array',
            'metadata' => 'array',
        ];
    }

    /**
     * Scope a query to active plans.
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }

    /**
     * Calculator tools included with this plan.
     */
    public function calculatorTools(): BelongsToMany
    {
        return $this->belongsToMany(CalculatorTool::class)->withTimestamps();
    }

    /**
     * Resolve a plan by one of its Stripe price IDs.
     */
    public static function resolveForPriceId(?string $priceId): ?self
    {
        if (! filled($priceId)) {
            return null;
        }

        return static::query()
            ->where('stripe_price_id_monthly', $priceId)
            ->orWhere('stripe_price_id_yearly', $priceId)
            ->first();
    }

    /**
     * Determine if the plan grants access to a feature.
     */
    public function supportsFeature(string $feature): bool
    {
        if ($this->relationLoaded('calculatorTools')) {
            return $this->calculatorTools->contains('slug', $feature);
        }

        if (Schema::hasTable('calculator_tools') && CalculatorTool::query()->where('slug', $feature)->exists()) {
            return $this->calculatorTools()->where('slug', $feature)->exists();
        }

        return in_array($feature, $this->feature_access ?? [], true);
    }

    /**
     * Get the Stripe price ID for the given billing interval.
     */
    public function getPriceId(string $interval = 'monthly'): ?string
    {
        return match ($interval) {
            'yearly' => $this->stripe_price_id_yearly,
            default => $this->stripe_price_id_monthly,
        };
    }

    /**
     * Get the local plan amount for the given billing interval.
     */
    public function getAmount(string $interval = 'monthly'): ?int
    {
        return match ($interval) {
            'yearly' => $this->yearly_price,
            default => $this->monthly_price,
        };
    }

    /**
     * Get the interval represented by the given Stripe price ID.
     */
    public function intervalForPriceId(?string $priceId): ?string
    {
        return match ($priceId) {
            $this->stripe_price_id_monthly => 'monthly',
            $this->stripe_price_id_yearly => 'yearly',
            default => null,
        };
    }

    /**
     * Get the billing intervals available on this plan.
     *
     * @return array<int, string>
     */
    public function intervalOptions(): array
    {
        return collect(['monthly', 'yearly'])
            ->filter(fn (string $interval) => filled($this->getAmount($interval)))
            ->values()
            ->all();
    }

    /**
     * Get a formatted money display for the given interval.
     */
    public function formattedAmount(string $interval = 'monthly'): ?string
    {
        $amount = $this->getAmount($interval);

        if (! filled($amount)) {
            return null;
        }

        return '$'.number_format($amount / 100, 2);
    }

    /**
     * Get the monthly-equivalent amount in cents.
     */
    public function monthlyEquivalentAmount(string $interval = 'monthly'): int
    {
        $amount = $this->getAmount($interval) ?? 0;

        return $interval === 'yearly'
            ? (int) round($amount / 12)
            : $amount;
    }
}
