<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventStoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_store', function (Blueprint $table) {
            $table->increments('id');

            $table->string('uuid', 36);
            $table->integer('playhead')->unsigned();
            $table->json('metadata');
            $table->json('payload');
            $table->string('recorded_on', 32);
            $table->text('type');

            $table->unique(['uuid', 'playhead']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('event_store');
    }
}
