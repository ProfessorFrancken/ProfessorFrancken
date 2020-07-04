<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCommissiesLegacyTable extends Migration
{
    protected $connection = 'francken-legacy';

    /**
     * Run the migrations.
     */
    public function up() : void
    {
        if (Schema::connection('francken-legacy')->hasTable('commissies')) {
            return;
        }

        Schema::connection('francken-legacy')->create('commissies', function (Blueprint $table) : void {
            $table->increments('id');
            $table->string('naam');
            $table->string('emailadres');
            $table->timestamps();
        });
    }
}
