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
            ["name" => "Energy and sustainability", 'icon' => 'tree'],
            ["name" => "Engineering", 'icon' => 'wrench'],
            ["name" => "Industry and utilities", 'icon' => 'industry'],
            ["name" => "Manufacturing", 'icon' => 'industry'],
            ["name" => "High tech electronics", 'icon' => 'microchip'],
            ["name" => "Financial services", 'icon' => 'line-chart'],
            ["name" => "Education", 'icon' => 'graduation-cap'],
            ["name" => "IT and programming", 'icon' => 'terminal'],
            ["name" => "Consulting and advisory", 'icon' => 'suitcase'],
            ["name" => "Gas, oil and petrochemical", 'icon' => 'tint'],
            ["name" => "Healthcare", 'icon' => 'medkit'],
            ["name" => "Defense and security", 'icon' => 'shield'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::table('extern_partner_sectors')->delete();
    }
}
