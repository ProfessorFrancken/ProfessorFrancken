<?php

declare(strict_types=1);

use Illuminate\Database\Seeder;

class ActivitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() : void
    {
        \Artisan::call('activities:update-ical');
    }
}
