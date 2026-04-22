<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Cashier\Subscription as CashierSubscription;

class Subscription extends CashierSubscription
{
    /**
     * Get the user that owns the subscription.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the Stripe price IDs represented by this subscription.
     *
     * @return array<int, string>
     */
    public function currentPriceIds(): array
    {
        return collect([$this->stripe_price])
            ->merge($this->relationLoaded('items') ? $this->items->pluck('stripe_price') : $this->items()->pluck('stripe_price'))
            ->filter()
            ->unique()
            ->values()
            ->all();
    }

    /**
     * Resolve the local plan represented by the subscription's price IDs.
     */
    public function plan(): ?Plan
    {
        foreach ($this->currentPriceIds() as $priceId) {
            $plan = Plan::resolveForPriceId($priceId);

            if ($plan) {
                return $plan;
            }
        }

        return null;
    }

    /**
     * Resolve the billing interval represented by the plan price ID.
     */
    public function interval(): ?string
    {
        $plan = $this->plan();

        if (! $plan) {
            return null;
        }

        foreach ($this->currentPriceIds() as $priceId) {
            $interval = $plan->intervalForPriceId($priceId);

            if ($interval) {
                return $interval;
            }
        }

        return null;
    }
}
