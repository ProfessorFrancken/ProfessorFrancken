<?php

declare(strict_types=1);

namespace Francken\Association\Photos\Http\Middleware;

use Closure;
use Francken\Association\Photos\Http\Controllers\AuthenticationController;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Http\Request;

final class LoginToViewPhotos
{
    private Gate $gate;

    public function __construct(Gate $gate)
    {
        $this->gate = $gate;
    }

    /**
     * Handle an incoming reques And verify if token exists and is valid
     */
    public function handle(Request $request, Closure $next)
    {
        if ( ! $this->gate->allows('view-albums')) {
            return redirect()->action([AuthenticationController::class, 'index']);
        }

        return $next($request);
    }
}
