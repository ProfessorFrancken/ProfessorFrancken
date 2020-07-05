<?php

declare(strict_types=1);

namespace Francken\Shared\Providers;

use Francken\Shared\Clock\Clock;
use Francken\Shared\Clock\SystemClock;
use Francken\Shared\Settings\Settings;
use Francken\Shared\Settings\ValueStoreSettings;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Spatie\Valuestore\Valuestore;

final class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register() : void
    {
        $this->app->instance('path', 'src');

        $this->app->bind(Valuestore::class, function (): Valuestore {
            return Valuestore::make(
                storage_path('app/settings.json')
            );
        });
        $this->app->bind(Settings::class, ValueStoreSettings::class);
        $this->app->bind(Clock::class, SystemClock::class);
    }

    public function boot() : void
    {
        Paginator::defaultView('components.pagination.default');

        Paginator::defaultSimpleView('components.pagination.simple-default');
    }
}
