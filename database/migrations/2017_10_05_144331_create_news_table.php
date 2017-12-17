<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title');
            $table->text('exerpt');
            $table->string('slug');
            $table->text('source_contents');
            $table->text('compiled_contents');
            $table->string('author_name');
            $table->string('author_photo');

            $table->json('related_news_items');

            $table->timestamp('published_at');
            $table->timestamps();
        });

        Schema::create('published_news', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title');
            $table->text('exerpt');
            $table->string('slug');
            $table->text('contents');
            $table->string('author_name');
            $table->string('author_photo');

            $table->timestamp('published_at');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('news');
        Schema::drop('published_news');
    }
}
