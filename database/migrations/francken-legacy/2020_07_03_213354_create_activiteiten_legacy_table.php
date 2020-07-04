<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateActiviteitenLegacyTable extends Migration
{
    protected $connection = 'francken-legacy';

    /**
     * Run the migrations.
     */
    public function up() : void
    {
        if (Schema::connection('francken-legacy')->hasTable('activiteiten')) {
            return;
        }

        Schema::connection('francken-legacy')->create('activiteiten', function (Blueprint $table) : void {
            $table->increments('id');
            $table->string('naam');
            $table->string('locatie', 511)->nullable();
            $table->dateTime('datum')->nullable();
            $table->dateTime('inschrijving_open')->nullable();
            $table->dateTime('inschrijving_dicht')->nullable();
            $table->boolean('streepprogramma')->default(1)->comment('Inschrijven via streepprogramma mogelijk');
            $table->decimal('prijs', 10, 4)->nullable()->default(0.0000);
            $table->string('afbeelding')->nullable();
            $table->text('notities', 65535)->nullable();
            $table->timestamps();
        });
    }
}
