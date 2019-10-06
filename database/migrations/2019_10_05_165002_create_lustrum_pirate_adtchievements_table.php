<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLustrumPirateAdtchievementsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::create('lustrum_pirate_adtchievements', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('adtchievement_id');
            $table->bigInteger('pirate_crew_id');
            $table->bigInteger('pirate_id');
            $table->integer('points');
            $table->text('reason')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lustrum_pirate_adtchievements');
    }
}
