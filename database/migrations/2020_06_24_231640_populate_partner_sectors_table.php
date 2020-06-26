<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;

class PopulatePartnerSectorsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        DB::table('extern_partner_sectors')->insert([
            ["name" => "Engineering", 'icon' => 'wrench'],
            ["name" => "High tech electronics", 'icon' => 'microchip'],
            ["name" => "Industry and utilities", 'icon' => 'industry'],
            ["name" => "Manufacturing", 'icon' => 'industry'],
            ["name" => "Financial services", 'icon' => 'line-chart'],
            ["name" => "IT and programming", 'icon' => 'terminal'],
            ["name" => "Energy and sustainability", 'icon' => 'tree'],
            ["name" => "Defense and security", 'icon' => 'shield'],
            ["name" => "Gas, oil and petrochemical", 'icon' => 'tint'],
            ["name" => "Healthcare", 'icon' => 'medkit'],
            ["name" => "Consulting and advisory", 'icon' => 'suitcase'],
            ["name" => "Education", 'icon' => 'graduation-cap'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        DB::table('extern_partner_sectors')->delete();
    }
}
