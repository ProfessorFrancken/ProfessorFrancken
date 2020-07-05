<?php

declare(strict_types=1);

namespace Francken\Shared\Providers;

use Francken\Shared\ViewComposers\MemberSelectionComposer;
use DateTimeImmutable;
use Francken\Extern\CompanyRepository;
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

        $this->app->singleton(MemberSelectionComposer::class);

        View::composer(
            'admin.association.boards._member-selection',
            MemberSelectionComposer::class
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
