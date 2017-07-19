<?php

namespace Francken\Infrastructure;

use Francken\Application\Career\CompanyRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

final class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('homepage._sponsors', function ($view) {
            $companies = $this->app->make(CompanyRepository::class);

            $view->with('footer', $companies->forFooter());
        });
    }

    public function associationIcon()
    {
        $now = new DateTimeImmutable;
        $fourOClock = DateTimeImmutable::createFromFormat('H a', '4 pm');
        $fourOClockMorning = DateTimeImmutable::createFromFormat('H a', '4 am');

        if ($fourOClockMorning < $now && $now < $fourOClock) {
            return 'coffee';
        }

        return 'beer';
    }
}
