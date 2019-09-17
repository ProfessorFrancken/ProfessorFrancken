<?php

declare(strict_types=1);

use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() : void
    {
        \Artisan::call('permission:setup');
    }
}
