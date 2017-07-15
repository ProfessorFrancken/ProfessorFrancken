<?php

namespace Francken\Infrastructure;

use Faker\Generator;
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
    }
}
