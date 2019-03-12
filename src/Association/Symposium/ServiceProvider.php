<?php

declare(strict_types=1);

namespace Francken\Association\Symposium;

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
    }

    public function boot() : void
    {
        $dispatcher = $this->app->make(Dispatcher::class);
        $dispatcher->listen(
            ParticipantRegisteredForSymposium::class,
            VerifyRegistration::class
        );

        $dispatcher->listen(
            ParticipantRegisteredForSymposium::class,
            NotifySymposiumCommittee::class
        );
    }
}
