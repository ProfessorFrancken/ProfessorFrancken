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

        if (LegacyMember::find(DatabaseSeeder::MEMBER_ID) === null) {
            factory(LegacyMember::class)->create([
                'id' => DatabaseSeeder::MEMBER_ID,
                'voornaam' => 'Mark',
                'achternaam' => 'Redeman'
            ]);
        }

        if (LegacyMember::find(1402) === null) {
            factory(LegacyMember::class)->create([
                // This is uesd in the EmailDeductionsFeature
                'id' => 1402,
            ]);
        }
    }
}
