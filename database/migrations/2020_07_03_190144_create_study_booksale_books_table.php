<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudyBooksaleBooksTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::create('study_booksale_books', function (Blueprint $table) : void {
            $table->id();

            $table->string('title');
            $table->integer('edition')->nullable();
            $table->string('isbn');
            $table->string('author');
            $table->string('cover_url')->nullable();

            $table->integer('seller_id')->unsigned()->nullable();
            $table->dateTime('taken_in_from_seller_at')->nullable();
            $table->text('description')->nullable();
            $table->integer('price')->unsigned();

            $table->integer('buyer_id')->unsigned()->nullable();
            $table->dateTime('taken_in_by_buyer_at')->nullable();

            $table->boolean('has_been_sold')->default(false);
            $table->boolean('paid_off')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('study_booksale_books');
    }
}
