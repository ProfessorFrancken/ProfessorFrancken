<?php

declare(strict_types=1);

namespace Francken\Shared\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class Authenticate
{
    /**
     * The Guard implementation.
     */
    protected Guard $guard;

    /**
     * Create a new middleware instance.
     * The guard instance is used to check if a user is authenticated
     *
     * @return void
     */
    public function __construct(Guard $guard)
    {
        $this->guard = $guard;
    }

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if ($this->guard->check()) {
            return $next($request);
        }

        return ($request->ajax())
            ? response('Unauthorized.', 401)
            : redirect()->guest('login');
    }
}
