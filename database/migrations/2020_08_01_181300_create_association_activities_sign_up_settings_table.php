<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssociationActivitiesSignUpSettingsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::create('association_activities_sign_up_settings', function (Blueprint $table) : void {
            $table->id();

            $table->bigInteger('activity_id')->unsigned();
            $table->foreign('activity_id')->references('id')->on('association_activities');

            $table->integer('max_sign_ups')->unsigned();
            $table->dateTime('deadline_at');
            $table->integer('costs_per_person')->unsigned();
            $table->integer('max_plus_ones_per_member')->unsigned();
            $table->boolean('ask_for_dietary_wishes');
            $table->boolean('ask_for_drivers_license');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('association_activities_sign_up_settings');
    }
}
