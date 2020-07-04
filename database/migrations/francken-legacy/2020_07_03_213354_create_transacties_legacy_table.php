<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTransactiesLegacyTable extends Migration
{
    protected $connection = 'francken-legacy';

    /**
     * Run the migrations.
     */
    public function up() : void
    {
        if (Schema::connection('francken-legacy')->hasTable('transacties')) {
            return;
        }

        Schema::connection('francken-legacy')->create('transacties', function (Blueprint $table) : void {
            $table->increments('id');
            $table->integer('lid_id')->unsigned()->index('transacties_lid_id_foreign');
            $table->integer('product_id')->unsigned()->index('transacties_product_id_foreign');
            $table->integer('aantal');
            $table->decimal('prijs', 10, 4);
            $table->decimal('totaalprijs', 10, 4);
            $table->dateTime('tijd')->index('tijd');
        });
    }
}
