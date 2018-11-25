<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhotosTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::create('photos', function (Blueprint $table) : void {
            $table->string('id');
            $table->primary('id');
            $table->string('album_id');

            $table->string('title')->nullable();
            $table->string('description')->nullable();

            $table->boolean('is_public')->default(false);
            $table->integer('views')->default(0);

            // Currently we use Flickr to host our photos, but at some point we
            // will probably be migrating to our own server
            $table->string('flickr_base_url');
            $table->string('flickr_original_url');

            $table->boolean('is_tall')->default(false);
            $table->boolean('is_wide')->default(false);

            $table->datetime('taken_at');
            $table->integer('latitude');
            $table->integer('longitude');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('photos');
    }
}
