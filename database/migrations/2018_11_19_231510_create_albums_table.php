<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlbumsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::create('albums', function (Blueprint $table) : void {
            $table->string('id');
            $table->primary('id');
            $table->datetime('published_at');
            $table->date('activity_date');
            $table->string('title');
            $table->text('description');
            $table->string('slug');
            $table->unique('slug');

            $table->boolean('is_public')->default(false);
            $table->boolean('is_prominent')->default(false);
            $table->string('cover_photo');

            $table->integer('views')->default(0);
            $table->integer('amount_of_photos')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('albums');
    }
}
