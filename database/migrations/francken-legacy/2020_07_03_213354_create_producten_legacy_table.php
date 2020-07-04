<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductenLegacyTable extends Migration
{
    protected $connection = 'francken-legacy';

    /**
     * Run the migrations.
     */
    public function up() : void
    {
        if (Schema::connection('francken-legacy')->hasTable('producten')) {
            return;
        }

        Schema::connection('francken-legacy')->create('producten', function (Blueprint $table) : void {
            $table->increments('id');
            $table->string('naam');
            $table->decimal('prijs', 10, 4);
            $table->string('categorie');
            $table->integer('positie');
            $table->boolean('beschikbaar');
            $table->string('afbeelding');
            $table->decimal('btw', 10, 4);
            $table->integer('eenheden');
            $table->timestamps();
        });
    }
}
