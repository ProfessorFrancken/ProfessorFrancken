<?php

declare(strict_types=1);

namespace Francken\Association\Borrelcie\Http\Middleware;

use Closure;
use Francken\Association\Borrelcie\Http\BorrelcieAccountActivationController;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class HasBorrelcieAccount
{
    /**
     * Handle an incoming reques And verify if token exists and is valid
     */
    public function handle(Request $request, Closure $next) : Response
    {
        $account = $request->user()->borrelcieAccount()->first();

        return $account === null
            ? redirect()->action([BorrelcieAccountActivationController::class, 'index'])
            : $next($request);
    }
}
