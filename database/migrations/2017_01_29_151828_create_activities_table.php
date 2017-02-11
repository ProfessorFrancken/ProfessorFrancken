<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('name');
            $table->boolean('false');
            // $table->description();
            $table->string('category');

            $table->dateTime('schedule_start');
            $table->dateTime('schedule_end')->nullable();

            $table->string('location_name');
            $table->string('location_postal_code')->nullable();
            $table->string('location_street_name')->nullable();
            $table->string('location_street_number')->nullable();

            $table->json('members');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activities');
    }
}
