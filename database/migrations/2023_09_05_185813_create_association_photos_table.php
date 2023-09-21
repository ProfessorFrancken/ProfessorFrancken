<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('association_photos', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('album_id')->unsigned()->nullable();
            $table->foreign('album_id')->references('id')->on('association_albums');

            $table->string('name')->nullable();
            $table->string('path');
            $table->string('visibility')->index();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('association_photos');
    }
};
