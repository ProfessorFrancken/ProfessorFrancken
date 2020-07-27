<?php

declare(strict_types=1);

namespace Francken\Shared\Providers;

use Barryvdh\Debugbar\ServiceProvider as DebugbarServiceProvider;
use Facade\Ignition\IgnitionServiceProvider;
use Illuminate\Support\ServiceProvider;

final class DevelopmentServiceProvider extends ServiceProvider
{
    public function register() : void
    {
        $this->app->register(DebugbarServiceProvider::class);
        $this->app->register(IgnitionServiceProvider::class);
    }
}
