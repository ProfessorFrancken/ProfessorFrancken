<?php

declare(strict_types=1);

namespace Francken\Infrastructure\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

final class ForceHttps
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (! app()->environment('local')) {
            // for Proxies
            Request::setTrustedProxies([$request->getClientIp()]);

            if (! $request->isSecure()) {
                return redirect()->secure($request->getRequestUri());
            }
        }

        return $next($request);
    }
}
