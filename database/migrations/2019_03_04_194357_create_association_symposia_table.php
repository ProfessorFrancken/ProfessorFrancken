<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssociationSymposiaTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::create('association_symposia', function (Blueprint $table) : void {
            $table->increments('id');
            $table->datetime('start_date');
            $table->datetime('end_date');
            $table->string('name');
            $table->string('location');

            $table->string('website_url');
            $table->boolean('open_for_registration');
            $table->boolean('promote_on_agenda');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('association_symposia');
    }
}
