<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBestellingenLegacyTable extends Migration
{
    protected $connection = 'francken-legacy';

    /**
     * Run the migrations.
     */
    public function up() : void
    {
        if (Schema::connection('francken-legacy')->hasTable('bestellingen')) {
            return;
        }

        Schema::connection('francken-legacy')->create('bestellingen', function (Blueprint $table) : void {
            $table->increments('id');
            $table->integer('leverancier_id')->unsigned();
            $table->date('datum');
            $table->text('notities', 65535)->nullable();
            $table->decimal('statiegeld_in', 10, 4)->nullable();
            $table->decimal('statiegeld_uit', 10, 4)->nullable();
            $table->timestamps();
        });
    }
}
