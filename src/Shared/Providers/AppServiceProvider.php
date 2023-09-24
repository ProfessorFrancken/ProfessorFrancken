<?php

declare(strict_types=1);

namespace Francken\Shared\Providers;

use Francken\Association\Photos\AlbumsRepository;
use Francken\Association\Photos\FlickrAlbumsRepository;
use Francken\Association\Photos\NextcloudAlbumsRepository;
use Francken\Shared\Clock\Clock;
use Francken\Shared\Clock\SystemClock;
use Francken\Shared\Settings\Settings;
use Francken\Shared\Settings\ValueStoreSettings;
use Francken\Shared\ViewComponents\Admin\Navigation;
use Francken\Shared\ViewComponents\Admin\NavigationGroup;
use Francken\Shared\ViewComponents\AutocompleteMemberComponent;
use Francken\Shared\ViewComponents\BorrelcieNotificationsComponent;
use Francken\Shared\ViewComponents\FooterSponsorsComponent;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Foundation\Application;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\ServiceProvider;
use League\Flysystem\Filesystem;
use League\Flysystem\WebDAV\WebDAVAdapter;
use Sabre\DAV\Client;
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

        $this->app->bind(Valuestore::class, fn () : Valuestore => Valuestore::make(
            storage_path('app/settings.json')
        ));
        $this->app->bind(Settings::class, ValueStoreSettings::class);
        $this->app->bind(Clock::class, SystemClock::class);
        if (config('francken.general.use_nextcloud')) {
            $this->app->bind(AlbumsRepository::class, NextcloudAlbumsRepository::class);
        } else {
            $this->app->bind(AlbumsRepository::class, FlickrAlbumsRepository::class);
        }


        if ($this->app instanceof Application && $this->app->isLocal()) {
            $this->app->register(DevelopmentServiceProvider::class);
        }

        Storage::extend(
            'nextcloud',
            function ($app, $config) {
                $client = new Client([
                    'baseUri' => $config['baseUri'],
                    'userName' => $config['username'],
                    'password' => $config['password']
                ]);

                $adapter = new WebDAVAdapter($client);
                $filesystem = new Filesystem($adapter);

                return new FilesystemAdapter($filesystem, $adapter);
            }
        );
    }

    public function boot() : void
    {
        Paginator::defaultView('components.pagination.default');

        Paginator::defaultSimpleView('components.pagination.simple-default');

        Blade::component('footer-sponsors', FooterSponsorsComponent::class);
        Blade::component('autocomplete-member', AutocompleteMemberComponent::class, 'forms');
        Blade::component('borrelcie-notifications', BorrelcieNotificationsComponent::class);

        Blade::components([
            Navigation::class,
            NavigationGroup::class,
        ], 'admin');
    }
}
