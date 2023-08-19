<?php

declare(strict_types=1);

namespace Francken\Shared\Http;

use Francken\Association\Borrelcie\Http\Middleware\HasBorrelcieAccount;
use Francken\Association\Photos\Http\Middleware\LoginToViewPhotos;
use Francken\PlusOne\Http\Middleware\AuthenticatePlusOne;
use Francken\Shared\Http\Middleware\Authenticate;
use Francken\Shared\Http\Middleware\CheckForMaintenanceMode;
use Francken\Shared\Http\Middleware\EnableCORS;
use Francken\Shared\Http\Middleware\EncryptCookies;
use Francken\Shared\Http\Middleware\RedirectIfAuthenticated;
use Francken\Shared\Http\Middleware\TrimStrings;
use Francken\Shared\Http\Middleware\VerifyCsrfToken;
use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull;
use Illuminate\Foundation\Http\Middleware\ValidatePostSize;
use Illuminate\Http\Middleware\SetCacheHeaders;
use Illuminate\Http\Middleware\TrustProxies;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Routing\Middleware\ValidateSignature;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Spatie\Permission\Middlewares\RoleMiddleware;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array<string>
     */
    protected $middleware = [
        CheckForMaintenanceMode::class,
        ValidatePostSize::class,
        TrimStrings::class,
        ConvertEmptyStringsToNull::class,

        TrustProxies::class,
        EnableCORS::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array<string, string[]>
     */
    protected $middlewareGroups = [
        'web' => [
            EncryptCookies::class,
            AddQueuedCookiesToResponse::class,
            StartSession::class,
            AuthenticateSession::class,
            ShareErrorsFromSession::class,
            VerifyCsrfToken::class,
            SubstituteBindings::class,
        ],
        'api' => [
            EnableCORS::class,
            SubstituteBindings::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array<string, string>
     */
    protected $routeMiddleware = [
        'auth' => Authenticate::class,
        'auth.basic' => AuthenticateWithBasicAuth::class,
        'bindings' => SubstituteBindings::class,
        'cache.headers' => SetCacheHeaders::class,
        'can' => Authorize::class,
        'role' => RoleMiddleware::class,
        'guest' => RedirectIfAuthenticated::class,
        'signed' => ValidateSignature::class,
        'throttle' => ThrottleRequests::class,
        'verified' => EnsureEmailIsVerified::class,
        'plus-one' => AuthenticatePlusOne::class,
        'symposium-cors' => \Francken\Association\Symposium\EnableCORS::class,
        'login-to-view-photos' => LoginToViewPhotos::class,
        'borrelcie' => HasBorrelcieAccount::class,
    ];

    /**
     * The priority-sorted list of middleware.
     *
     * This forces non-global middleware to always be in the given order.
     *
     * @var array<string>
     */
    protected $middlewarePriority = [
        StartSession::class,
        ShareErrorsFromSession::class,
        Authenticate::class,
        ThrottleRequests::class,
        AuthenticateSession::class,
        SubstituteBindings::class,
        Authorize::class,
    ];
}
