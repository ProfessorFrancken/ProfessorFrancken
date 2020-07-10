<?php

declare(strict_types=1);

namespace Francken\Shared\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * This middelware adds the action belonging to the current route, e.g.
 * "IndexController" to the view.
 * This is useful as it allows us to have action([$controller, 'show', $parameters)
 * in our index views
 */
final class AddRouteActionToView
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next) : Response
    {
        $response = $next($request);
        $action = Route::getCurrentRoute()->getAction();

        [$controller, $method] = explode('@', $action['controller']);


        // dd($response->original);
        // $response->original->with([
        //     'controller' => $controller,
        //     'method' => $method,
        //     'namespace' => $action['namespace'],
        // ]);

        return $response;
    }
}
