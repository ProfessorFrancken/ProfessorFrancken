<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVakgroepenLegacyTable extends Migration
{
    protected $connection = 'francken-legacy';

    /**
     * Run the migrations.
     */
    public function up() : void
    {
        if (Schema::connection('francken-legacy')->hasTable('vakgroepen')) {
            return;
        }

        Schema::connection('francken-legacy')->create('vakgroepen', function (Blueprint $table) : void {
            $table->increments('id');
            $table->string('naam');
            $table->string('geslacht');
            $table->string('titel');
            $table->string('initialen');
            $table->string('voornaam');
            $table->string('tussenvoegsel');
            $table->string('achternaam');
            $table->date('geboortedatum')->nullable();
            $table->string('adres', 511);
            $table->string('postcode');
            $table->string('plaats');
            $table->string('land');
            $table->string('kamernummer');
            $table->string('telefoonnummer');
            $table->string('faxnummer');
            $table->string('emailadres');
            $table->string('website');
            $table->text('notities', 65535);
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
