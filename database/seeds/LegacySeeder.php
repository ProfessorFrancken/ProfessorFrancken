<?php

declare(strict_types=1);

use Francken\Association\LegacyMember;
use Illuminate\Database\Seeder;

class LegacySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() : void
    {
        \Artisan::call('migrate:legacy-db');
    }
}
