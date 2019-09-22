<?php

declare(strict_types=1);

namespace Francken\Shared\Providers;

use DateTimeImmutable;
use Francken\Application\Career\CompanyRepository;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

final class ViewServiceProvider extends ServiceProvider
{
    public function boot() : void
    {
        View::composer('layout._sponsors', function ($view) : void {
            $companies = $this->app->make(CompanyRepository::class);

            $view->with('footer', $companies->forFooter());
        });

        $this->app->singleton(\Francken\Shared\ViewComposers\MemberSelectionComposer::class);

        View::composer(
            'admin.association.boards._member-selection',
            \Francken\Shared\ViewComposers\MemberSelectionComposer::class
        );
    }

    public function associationIcon()
    {
        $now = new DateTimeImmutable();
        $fourOClock = DateTimeImmutable::createFromFormat('H a', '4 pm');
        $fourOClockMorning = DateTimeImmutable::createFromFormat('H a', '4 am');

        if ($fourOClockMorning < $now && $now < $fourOClock) {
            return 'coffee';
        }

        return 'beer';
    }
}
