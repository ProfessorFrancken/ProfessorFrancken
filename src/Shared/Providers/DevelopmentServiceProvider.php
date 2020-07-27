<?php

declare(strict_types=1);

namespace Francken\Shared\Providers;

use Illuminate\Support\ServiceProvider;

final class DevelopmentServiceProvider extends ServiceProvider
{
    public function register() : void
    {
        $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        $this->app->register(\Facade\Ignition\IgnitionServiceProvider::class);
    }
}
