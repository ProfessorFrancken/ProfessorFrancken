<?php

declare(strict_types=1);

namespace Francken\Association\Activities;

use Illuminate\Console\Command;

class FetchLatestFranckenIcal extends Command
{
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
        $url = 'https://calendar.google.com/calendar/ical/g8f50ild2kdf49bgathcdhvcqc%40group.calendar.google.com/public/basic.ics';
        $file = file_get_contents($url);

        if ($file) {
            \Storage::put('calendar.ics', $file);
        }
    }
}
