<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTellingProductLegacyTable extends Migration
{
    protected $connection = 'francken-legacy';

    /**
     * Run the migrations.
     */
    public function up() : void
    {
        if (Schema::connection('francken-legacy')->hasTable('telling_product')) {
            return;
        }

        Schema::connection('francken-legacy')->create('telling_product', function (Blueprint $table) : void {
            $table->increments('id');
            $table->integer('telling_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->integer('aantal');
            $table->timestamps();
        });
    }
}
