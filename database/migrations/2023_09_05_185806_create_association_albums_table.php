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
        Schema::create('association_albums', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');

            $table->date('published_at')->index();
            $table->string('visibility')->index();
            $table->string('slug');
            $table->unique('slug');

            $table->string('disk');
            $table->string('path');

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
        Schema::dropIfExists('association_albums');
    }
};
