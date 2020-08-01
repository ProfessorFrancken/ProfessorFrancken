<?php

declare(strict_types=1);

namespace Francken\Association\Activities;

use Illuminate\Console\Command;

class FetchLatestFranckenIcal extends Command
{
    private const GOOGLE_CALENDAR_URL =  'https://calendar.google.com/calendar/ical/g8f50ild2kdf49bgathcdhvcqc%40group.calendar.google.com/public/basic.ics';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'activities:update-ical';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Retrieve and store the current ical from Francken's public google calendar";

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle() : void
    {
        $file = file_get_contents(self::GOOGLE_CALENDAR_URL);

        if ($file) {
            \Storage::put('calendar.ics', $file);
        }
    }
}
