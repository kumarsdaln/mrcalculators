<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Support\CalculatorCatalog;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Plan::query()->updateOrCreate(
            ['slug' => 'starter'],
            [
                'name' => 'Starter',
                'description' => 'Core planning calculators for smaller operators and finance teams getting started.',
                'stripe_price_id_monthly' => 'price_starter_monthly',
                'stripe_price_id_yearly' => 'price_starter_yearly',
                'monthly_price' => 1900,
                'yearly_price' => 19000,
                'currency' => 'usd',
                'trial_days' => 7,
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 1,
                'feature_access' => [
                    'monthly_sales_goal',
                    'break_even_price',
                    'audit_history',
                ],
            ]
        );

        Plan::query()->updateOrCreate(
            ['slug' => 'growth'],
            [
                'name' => 'Growth',
                'description' => 'Adds forecasting and scenario planning for scaling teams that need more visibility.',
                'stripe_price_id_monthly' => 'price_growth_monthly',
                'stripe_price_id_yearly' => 'price_growth_yearly',
                'monthly_price' => 4900,
                'yearly_price' => 49000,
                'currency' => 'usd',
                'trial_days' => 7,
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 2,
                'feature_access' => [
                    'monthly_sales_goal',
                    'break_even_price',
                    'future_sales_forecast',
                    'what_if_engine',
                    'audit_history',
                ],
            ]
        );

        Plan::query()->updateOrCreate(
            ['slug' => 'scale'],
            [
                'name' => 'Scale',
                'description' => 'Unlock the full calculator suite, billing-grade workflows, and data import tools.',
                'stripe_price_id_monthly' => 'price_scale_monthly',
                'stripe_price_id_yearly' => 'price_scale_yearly',
                'monthly_price' => 9900,
                'yearly_price' => 99000,
                'currency' => 'usd',
                'trial_days' => 14,
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 3,
                'feature_access' => CalculatorCatalog::featureSlugs(),
            ]
        );
    }
}
