<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLustrumPiratesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::create('lustrum_pirates', function (Blueprint $table) : void {
            $table->bigIncrements('id');
            $table->unsignedInteger('member_id');
            $table->unsignedBigInteger('pirate_crew_id');
            $table->string('name');
            $table->string('title');
            $table->integer('earned_points');

            $table->timestamps();

            $table->foreign('pirate_crew_id')->references('id')->on('lustrum_pirate_crews');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('lustrum_pirates');
    }
}
