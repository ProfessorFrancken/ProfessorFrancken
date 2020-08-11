<?php

declare(strict_types=1);

namespace Francken\Shared\Providers;

use Francken\Shared\Clock\Clock;
use Francken\Shared\Clock\SystemClock;
use Francken\Shared\Settings\Settings;
use Francken\Shared\Settings\ValueStoreSettings;
use Francken\Shared\ViewComponents\AutocompleteMemberComponent;
use Francken\Shared\ViewComponents\Admin\Navigation;
use Francken\Shared\ViewComponents\Admin\NavigationGroup;
use Francken\Shared\ViewComponents\FooterSponsorsComponent;
use Illuminate\Foundation\Application;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Spatie\Valuestore\Valuestore;

final class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register() : void
    {
        if ($this->app instanceof Application) {
            $this->app->useAppPath(base_path('src'));
        }

        $this->app->bind(Valuestore::class, function () : Valuestore {
            return Valuestore::make(
                storage_path('app/settings.json')
            );
        });
        $this->app->bind(Settings::class, ValueStoreSettings::class);
        $this->app->bind(Clock::class, SystemClock::class);

        if ($this->app instanceof Application && $this->app->isLocal()) {
            $this->app->register(DevelopmentServiceProvider::class);
        }
    }

    public function boot() : void
    {
        Paginator::defaultView('components.pagination.default');

        Paginator::defaultSimpleView('components.pagination.simple-default');

        Blade::component('footer-sponsors', FooterSponsorsComponent::class);
        Blade::component('autocomplete-member', AutocompleteMemberComponent::class, 'forms');

        Blade::components([
            Navigation::class,
            NavigationGroup::class,
        ], 'admin');
    }
}
