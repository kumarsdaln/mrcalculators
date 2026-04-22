<?php

namespace App\Http\Middleware;

use App\Support\CalculatorCatalog;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $user = $request->user();

        return [
            ...parent::share($request),
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'error' => fn () => $request->session()->get('error'),
            ],
            'auth' => [
                'user' => $user ? [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'email_verified_at' => optional($user->email_verified_at)->toIso8601String(),
                    'company_name' => $user->company_name,
                    'phone' => $user->phone,
                    'billing_address_line1' => $user->billing_address_line1,
                    'billing_address_line2' => $user->billing_address_line2,
                    'billing_city' => $user->billing_city,
                    'billing_state' => $user->billing_state,
                    'billing_postal_code' => $user->billing_postal_code,
                    'billing_country' => $user->billing_country,
                    'role' => $user->role,
                    'is_admin' => $user->isAdmin(),
                    'initials' => $user->initials,
                ] : null,
                'subscription' => $user?->billingSummary(),
            ],
            'catalog' => [
                'features' => CalculatorCatalog::all(),
            ],
        ];
    }
}
