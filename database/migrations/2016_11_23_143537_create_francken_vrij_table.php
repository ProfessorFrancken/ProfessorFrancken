<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFranckenVrijTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('francken_vrij', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('title');
            $table->integer('volume');
            $table->integer('edition');
            $table->string('pdf');
            $table->string('cover');

            $table->unique(['volume', 'edition']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('francken_vrij');
    }
}
