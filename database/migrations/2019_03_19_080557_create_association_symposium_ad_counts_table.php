<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssociationSymposiumAdCountsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::create('association_symposium_ad_counts', function (Blueprint $table) : void {
            $table->increments('id');
            $table->unsignedInteger('participant_id');
            $table->unsignedInteger('symposium_id');
            $table->string('name');
            $table->boolean('consumed')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('association_symposium_ad_counts');
    }
}
