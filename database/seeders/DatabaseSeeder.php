<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(CalculatorToolSeeder::class);
        $this->call(PlanSeeder::class);
        $this->call(AdminUserSeeder::class);

        $user = User::query()->firstOrCreate([
            'email' => 'test@example.com',
        ], [
            'name' => 'Test User',
            'company_name' => 'Demo Finance Team',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        if (! $user->subscribed('default')) {
            $subscription = $user->subscriptions()->create([
                'type' => 'default',
                'stripe_id' => 'sub_fake_' . \Illuminate\Support\Str::random(10),
                'stripe_status' => 'active',
            ]);

            $subscription->items()->create([
                'stripe_id' => 'item_fake_' . \Illuminate\Support\Str::random(10),
                'stripe_product' => 'prod_fake',
                'stripe_price' => 'price_scale_monthly',
                'quantity' => 1,
            ]);
        }
    }
}
