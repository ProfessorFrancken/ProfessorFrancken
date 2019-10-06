<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLustrumAdtchievementsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::create('lustrum_adtchievements', function (Blueprint $table) : void {
            $table->bigIncrements('id');
            $table->string('title');
            $table->text('description');
            $table->string('past_tense')->nullable();
            $table->integer('points');
            $table->boolean('is_repeatable')->default(false);
            $table->boolean('is_team_effort')->default(false);
            $table->boolean('is_hidden')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('lustrum_adtchievements');
    }
}
