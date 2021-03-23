<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssociationSoundboardsSoundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('association_soundboards_sounds', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('soundboard_id')->unsigned();
            $table->foreign('soundboard_id')->references('id')->on('association_soundboards');

            $table->string('name');

            $table->integer('uploaded_by_member_id')->unsigned();

            $table->integer('audio_media_id')->unsigned();
            $table->foreign('audio_media_id')->references('id')->on('media');

            $table->integer('image_media_id')->unsigned()->nullable();
            $table->foreign('image_media_id')->references('id')->on('media');

            $table->string('css_background')->nullable();
            $table->string('css_foreground')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('association_soundboards_sounds');
    }
}
