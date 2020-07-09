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

        factory(LegacyMember::class)->create([
            'id' => DatabaseSeeder::MEMBER_ID,
            'voornaam' => 'Mark',
            'achternaam' => 'Redeman'
        ]);

        factory(LegacyMember::class)->create([
            // This is uesd in the EmailDeductionsFeature
            'id' => 1402,
        ]);
    }
}
