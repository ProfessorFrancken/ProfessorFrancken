<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBestellingProductLegacyTable extends Migration
{
    protected $connection = 'francken-legacy';

    /**
     * Run the migrations.
     */
    public function up() : void
    {
        if (Schema::connection('francken-legacy')->hasTable('bestelling_product')) {
            return;
        }

        Schema::connection('francken-legacy')->create('bestelling_product', function (Blueprint $table) : void {
            $table->increments('id');
            $table->integer('bestelling_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->integer('aantal');
            $table->decimal('inkoopprijs', 10, 4)->default(0.0000);
            $table->timestamps();
        });
    }
}
