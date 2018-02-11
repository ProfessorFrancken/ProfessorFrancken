<?php

declare(strict_types=1);

namespace Francken\Infrastructure\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Fideloper\Proxy\TrustProxies::class,
        \Francken\Infrastructure\Http\Middleware\ForceHttps::class,
        \Francken\Infrastructure\Http\Middleware\EnableCORS::class

    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \Francken\Infrastructure\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Francken\Infrastructure\Http\Middleware\VerifyCsrfToken::class,
        ],
        'api' => [
            \Francken\Infrastructure\Http\Middleware\EnableCORS::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \Francken\Infrastructure\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'guest' => \Francken\Infrastructure\Http\Middleware\RedirectIfAuthenticated::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,

    ];
}
