<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssociationActivitiesSignUpsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::create('association_activities_sign_ups', function (Blueprint $table) : void {
            $table->id();

            $table->integer('member_id')->unsigned();

            $table->bigInteger('activity_id')->unsigned();
            $table->foreign('activity_id')->references('id')->on('association_activities');

            $table->integer('plus_ones')->unsigned();
            $table->string('dietary_wishes');
            $table->boolean('has_drivers_license');
            $table->text('notes');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('association_activities_sign_ups');
    }
}
