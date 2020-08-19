<?php

declare(strict_types=1);

namespace Francken\Shared\Providers;

use DateTimeImmutable;
use DateTimeZone;
use Francken\Association\Members\Http\ProfileActivitiesController;
use Francken\Auth\Account;
use Francken\Shared\Http\Controllers\DashboardController;
use Francken\Shared\Settings\Settings;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

final class NavigationServiceProvider extends ServiceProvider
{
    public function boot() : void
    {
        View::composer('layout._header', function ($view) : void {
            /** @var array $menu */
            $menu = config('francken.navigation.menu');
            $menu[1]['icon'] = $this->associationIcon();

            $settings = $this->app->make(Settings::class);
            if ($settings->isPienterShownInNavigation()) {
                $menu[] = [
                    'url' => 'http://pienterkamp.nl/',
                    'title' => 'Pienterkamp',
                    'subItems' => [],
                    'icon' => 'child'
                ];
            }
            if ($settings->isSymposiumShownInNavigation()) {
                $menu[] = [
                    'url' => 'https://franckensymposium.nl',
                    'title' => 'Symposium',
                    'subItems' => [],
                    'icon' => 'globe-europe',
                ];
            }
            if ($settings->isSlefShownInNavigation()) {
                $menu[] = [
                    'url' => 'https://slef.nl',
                    'title' => 'Slef',
                    'subItems' => [],
                    'icon' => 'globe-europe',
                ];
            }
            if ($settings->isExpeditionShownInNavigation()) {
                $menu[] = [
                    'url' => 'https://expeditionstrategy.nl/',
                    'title' => 'Expedition Strategy',
                    'subItems' => [],
                    'icon' => 'building',
                ];
            }

            $account = Auth::user();
            if ($account !== null && $account instanceof Account) {
                $menu[] = [
                    'url' => '/profile',
                    'title' => 'Profile',
                    'icon' => 'user',
                    'subItems' => array_filter([
                        // Job prospects
                        ['url' => '/profile/expenses', 'icon' => 'fa fa-chart-bar', 'title' => 'Expenses'],
                        ['url' => action([ProfileActivitiesController::class, 'index']), 'icon' => 'fa fa-calendar', 'title' => 'Activities'],

                        ($account->can('can-access-dashboard')
                         ? ['url' => action([DashboardController::class, 'redirectToDashboard']), 'icon' => 'fa fa-database', 'title' => 'Admin', 'can' => 'can-access-dashboard']
                         : []),
                        ['url' => route('get-logout'), 'icon' => 'fas fa-sign-out-alt', 'title' => 'Logout']
                    ]),
                ];
            } elseif ($settings->isLoginShownInNavigation()) {
                $menu[] = [
                    'url' => route('login'),
                    'title' => 'Login',
                    'subItems' => [],
                    'icon' => '',
                    'class' => 'login-link',
                ];
            }

            $gate = $this->app->make(Gate::class);
            $view->with('items', array_filter($menu, function ($item) use ($gate) : bool {
                // If no permission rule is set always allow showing the item
                return ! isset($item['can']) || $gate->allows($item['can']);
            }));
        });

        View::composer('homepage._pillars', function ($view) : void {
            $view->with('associationIcon', $this->associationIcon());
        });
    }

    private function associationIcon() : string
    {
        $now = (new DateTimeImmutable())
            ->setTimeZone(new DateTimeZone('Europe/Amsterdam'));

        $fourOClock = (new DateTimeImmutable('4 pm'))
            ->setTimeZone(new DateTimeZone('Europe/Amsterdam'));

        $fourOClockMorning = ( new DateTimeImmutable('4 am'))
            ->setTimeZone(new DateTimeZone('Europe/Amsterdam'));

        if ($fourOClockMorning < $now && $now < $fourOClock) {
            return 'coffee';
        }

        return 'beer';
    }
}
