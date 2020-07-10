<?php

declare(strict_types=1);

namespace Francken\Association\Symposium;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class EnableCORS
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next) : Response
    {
        $response = $next($request);

        return $response->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    }
}
