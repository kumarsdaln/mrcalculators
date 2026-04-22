<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class EnsureFeatureAccess
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $feature): Response
    {
        $user = $request->user();

        if ($user && $user->hasFeatureAccess($feature)) {
            return $next($request);
        }

        $message = 'Your current plan does not include '.Str::headline(str_replace('_', ' ', $feature)).'.';

        if ($request->expectsJson()) {
            return new JsonResponse([
                'message' => $message,
                'upgrade_url' => route('billing.index'),
            ], Response::HTTP_FORBIDDEN);
        }

        /** @var RedirectResponse $response */
        $response = redirect()->route('billing.index')->with('error', $message);

        return $response;
    }
}
