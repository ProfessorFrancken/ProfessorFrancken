<?php

declare(strict_types=1);

namespace Francken\Infrastructure\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class Authenticate
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $guard;

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
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function handle($request, Closure $next)
    {
        if ($this->guard->check()) {
            return $next($request);
        }

        return ($request->ajax())
            ? response('Unauthorized.', 401)
            : redirect()->guest('login');
    }
}
