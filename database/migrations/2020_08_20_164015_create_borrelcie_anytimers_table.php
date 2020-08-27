<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBorrelcieAnytimersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::create('borrelcie_anytimers', function (Blueprint $table) : void {
            $table->id();
            $table->integer('drinker_id')->unsigned();
            $table->integer('owner_id')->unsigned();
            $table->boolean('accepted');
            $table->integer('amount');
            $table->string('reason')->nullable();
            $table->string('context');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('borrelcie_anytimers');
    }
}
