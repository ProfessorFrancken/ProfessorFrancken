<?php

namespace Francken\Infrastructure;

use Faker\Generator;
use Francken\Application\Career\CompanyRepository;
use Francken\Application\Career\JobOpeningRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

final class CareerServiceProvider extends ServiceProvider
{
    public function register()
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
    }
}
