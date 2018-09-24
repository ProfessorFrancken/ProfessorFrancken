<?php

declare(strict_types=1);

namespace Francken\Infrastructure\Console;

use Francken\Association\News\Xml\ImportIntoEloquent;
use Francken\Association\Activities\FetchLatestFranckenIcal;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        ImportIntoEloquent::class,
        FetchLatestFranckenIcal::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('activities:update-ical')->hourly();
    }
}
