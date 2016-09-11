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
            $table->string('author');
            $table->integer('price'); //in cents
            $table->string('isbn_10', 10);
            $table->string('path_to_cover');
            $table->boolean('sale_pending');
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
