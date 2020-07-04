<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAfschrijvingenLegacyTable extends Migration
{
    protected $connection = 'francken-legacy';

    /**
     * Run the migrations.
     */
    public function up() : void
    {
        if (Schema::connection('francken-legacy')->hasTable('afschrijvingen')) {
            return;
        }

        Schema::connection('francken-legacy')->create('afschrijvingen', function (Blueprint $table) : void {
            $table->increments('id');
            $table->dateTime('tijd');
            $table->timestamps();
        });
    }
}
