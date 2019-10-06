<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLustrumPirateCrewsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::create('lustrum_pirate_crews', function (Blueprint $table) : void {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('slug');
            $table->string('logo');
            $table->integer('total_points')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('lustrum_pirate_crews');
    }
}
