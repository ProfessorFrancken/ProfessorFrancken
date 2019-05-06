<?php

declare(strict_types=1);

namespace Francken\Infrastructure\Console;

use Francken\Association\Activities\FetchLatestFranckenIcal;
use Francken\Association\News\Xml\ImportIntoEloquent;
use Francken\Association\Photos\SynchronizeFlickrAlbums;
use Francken\Association\Symposium\SendInformationEmail;
use Francken\Auth\ImportPermissionsFromConfig;
use Francken\Auth\SetupPermissions;
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
        ImportPermissionsFromConfig::class,
        SetupPermissions::class,
        ImportIntoEloquent::class,
        FetchLatestFranckenIcal::class,
        SynchronizeFlickrAlbums::class,
        SendInformationEmail::class,
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule) : void
    {
        $schedule->command('activities:update-ical')->hourly();
        $schedule->command('photos:synchronize')->hourly();
    }
}
