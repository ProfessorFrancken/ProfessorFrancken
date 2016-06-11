<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAllBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('all_books', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('title');
            $table->string('authors');
            $table->string('isbn-10', 10);
            $table->string('path_to_cover');
            $table->integer('price');   //in cents
            $table->string('sold_by');
            $table->string('sold_to');
            $table->enum('state', ['available', 'pending', 'sold']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('all_books');
    }
}
