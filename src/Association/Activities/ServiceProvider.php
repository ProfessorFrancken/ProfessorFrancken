<?php

declare(strict_types=1);

namespace Francken\Association\Activities;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Illuminate\View\Factory;
use Webmozart\Assert\Assert;

final class ServiceProvider extends BaseServiceProvider
{
    public function boot() : void
    {
        $view = $this->app->make(Factory::class);

        $view->composer(
            'association.activities.index',
            ActivitiesSidebarComposer::class
        );

        $view->composer(
            'association.activities.show',
            ActivitiesSidebarComposer::class
        );

        $view->composer(
            'association.activities.sign-ups.edit',
            ActivitiesSidebarComposer::class
        );

        $view->composer(
            'association.activities.ical',
            ActivitiesSidebarComposer::class
        );

        $this->app->bind(
            ActivitiesRepository::class,
            function () : ActivitiesRepository {
                $calendarFile = fopen(storage_path('app/calendar.ics'), 'r');
                Assert::resource($calendarFile);
                return new ActivitiesRepository($calendarFile);
            }
        );
    }
}
