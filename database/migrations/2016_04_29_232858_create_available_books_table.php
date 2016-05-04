<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAvailableBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('available_books', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('title');
            $table->string('authors');
            $table->string('isbn', 10);
            $table->integer('price'); //in cents
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('available_books');
    }
}
