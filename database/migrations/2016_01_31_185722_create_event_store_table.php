<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Config\Repository;

class CreateEventStoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table = App::make(Repository::class)
                    ->get('event_sourcing.event_store_table');

        Schema::create($table, function (Blueprint $table) {
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
