<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateActiviteitLidLegacyTable extends Migration
{
    protected $connection = 'francken-legacy';

    /**
     * Run the migrations.
     */
    public function up() : void
    {
        if (Schema::connection('francken-legacy')->hasTable('activiteit_lid')) {
            return;
        }

        Schema::connection('francken-legacy')->create('activiteit_lid', function (Blueprint $table) : void {
            $table->increments('id');
            $table->integer('activiteit_id')->unsigned();
            $table->integer('lid_id')->unsigned();
            $table->timestamp('inschrijfdatum')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->decimal('prijs', 10, 4)->default(0.0000);
            $table->timestamps();
        });
    }
}
