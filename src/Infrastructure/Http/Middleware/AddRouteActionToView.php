<?php

declare(strict_types=1);

namespace Francken\Infrastructure\Http\Middleware;

use Closure;

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
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $action = \Route::getCurrentRoute()->getAction();

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
