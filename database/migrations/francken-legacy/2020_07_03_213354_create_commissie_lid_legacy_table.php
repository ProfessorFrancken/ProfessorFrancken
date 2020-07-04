<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCommissieLidLegacyTable extends Migration
{
    protected $connection = 'francken-legacy';

    /**
     * Run the migrations.
     */
    public function up() : void
    {
        if (Schema::connection('francken-legacy')->hasTable('commissie_lid')) {
            return;
        }

        Schema::connection('francken-legacy')->create('commissie_lid', function (Blueprint $table) : void {
            $table->increments('id');
            $table->integer('lid_id')->unsigned()->index('lid_commissie_jaar_lid_id_foreign');
            $table->integer('commissie_id')->unsigned()->index('lid_commissie_jaar_commissie_id_foreign');
            $table->integer('jaar');
            $table->string('functie');
            $table->timestamps();
        });
    }
}
