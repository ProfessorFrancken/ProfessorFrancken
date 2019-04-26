<?php

declare(strict_types=1);

namespace Francken\Auth;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

final class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register any application services.
     */
    public function register() : void
    {
        $this->app->singleton(GateContract::class, function ($app) {
            return new GateThatAllowsGuestsInCallables($app, function () use ($app) {
                return call_user_func($app['auth']->userResolver());
            });
        });

        \Horizon::auth(function ($request) {
            $user = $request->user();

            if ($user === null) {
                return false;
            }

            return $user->hasRole('Admin');
        });
    }

    public function boot(GateContract $gate) : void
    {
        $gate->before(function ($user, $ability) {
            return $user->hasRole('Admin') ? true : null;
        });

        $dispatcher = $this->app->make(Dispatcher::class);
        $dispatcher->listen(AccountWasActivated::class, ChangeRolesListener::class);
    }
}
