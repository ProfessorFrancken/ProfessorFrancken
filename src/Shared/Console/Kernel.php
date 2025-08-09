<?php

declare(strict_types=1);

namespace Francken\Shared\Console;

use Francken\Association\Activities\FetchLatestFranckenIcal;
use Francken\Association\Activities\ImportActivitiesFromCalendar;
use Francken\Association\Boards\UpdateBoardMemberStatus;
use Francken\Association\Photos\UpdatePhotoMetadata;
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
        FetchLatestFranckenIcal::class,
        ImportActivitiesFromCalendar::class,
        ImportPermissionsFromConfig::class,
        SendInformationEmail::class,
        SetupPermissions::class,
        UpdateBoardMemberStatus::class,
        UpdatePhotoMetadata::class,
        MigrateLegacyDb::class,
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule) : void
    {
        $schedule->command('activities:update-ical')
            ->hourly()
            ->after(fn () => $this->call('activities:import'));

        $schedule->command('photos:synchronize')->hourly();
        $schedule->command('boards:update-board-member-status')->daily();
    }
}
