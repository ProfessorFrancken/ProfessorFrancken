<?php

declare(strict_types=1);

namespace Francken\Extern;

use Illuminate\Support\ServiceProvider;

final class ExternServiceProvider extends ServiceProvider
{
    public function register() : void
    {
        $this->app->bind(JobOpeningRepository::class, function ($app) : JobOpeningRepository {
            $jobs = file_exists(database_path('vacancies.php'))
                ? require database_path('vacancies.php')
                : [];

            return new JobOpeningRepository(
                $jobs
            );
        });

        $this->app->bind(EventRepository::class, function ($app) : EventRepository {
            $events = file_exists(database_path('events.php'))
                ? require database_path('events.php')
                : [];

            return new EventRepository(
                $events['planned'] ?? [],
                $events['past'] ?? []
            );
        });
    }
}
