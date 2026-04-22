<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()?->isAdmin()) {
            if ($request->expectsJson()) {
                return new JsonResponse([
                    'message' => 'Administrator access is required for this action.',
                ], Response::HTTP_FORBIDDEN);
            }

            /** @var RedirectResponse $response */
            $response = redirect()->route('dashboard')->with('error', 'Administrator access is required for that page.');

            return $response;
        }

        return $next($request);
    }
}
