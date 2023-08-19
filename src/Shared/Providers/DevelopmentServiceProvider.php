<?php

declare(strict_types=1);

namespace Francken\Shared\Providers;

use Barryvdh\Debugbar\ServiceProvider as DebugbarServiceProvider;
use Francken\Tests\Association\Newsletter\NullDriver;
use Illuminate\Support\ServiceProvider;
use Spatie\LaravelIgnition\IgnitionServiceProvider;
use Spatie\Newsletter\Newsletter;

final class DevelopmentServiceProvider extends ServiceProvider
{
    public function register() : void
    {
        $this->app->register(DebugbarServiceProvider::class);
        $this->app->register(IgnitionServiceProvider::class);
        $this->registerNewsletter();
    }

    private function registerNewsletter() : void
    {
        $driver = config('newsletter.driver', 'api');
        if (is_null($driver) || $driver === 'log') {
            $this->app->singleton(Newsletter::class, fn () : NullDriver => new NullDriver());
        }
    }
}
