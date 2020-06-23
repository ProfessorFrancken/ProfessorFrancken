<?php

declare(strict_types=1);

namespace Francken\Shared\Providers;

use Francken\Extern\CompanyRepository;
use Francken\Extern\EventRepository;
use Francken\Extern\JobOpeningRepository;
use Illuminate\Support\ServiceProvider;

final class CareerServiceProvider extends ServiceProvider
{
    public function register() : void
    {
        $this->app->bind(JobOpeningRepository::class, function ($app) {
            $jobs = file_exists(database_path('vacancies.php'))
                ? require database_path('vacancies.php')
                : [];

            return new JobOpeningRepository(
                $jobs
            );
        });

        $this->app->bind(CompanyRepository::class, function ($app) {
            $companies = file_exists(database_path('companies.php'))
                ? require database_path('companies.php')
                : [];

            return new CompanyRepository(
                $companies
            );
        });

        $this->app->bind(EventRepository::class, function ($app) {
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
