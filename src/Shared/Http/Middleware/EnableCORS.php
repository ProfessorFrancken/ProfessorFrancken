<?php

declare(strict_types=1);

namespace Francken\Shared\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

final class EnableCORS
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($request->segment(2) === "pluimpje" || $request->segment(1) === "api") {
            return $response->header('Access-Control-Allow-Origin', '*')
                ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization')
                ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        }

        return $response;
    }
}
