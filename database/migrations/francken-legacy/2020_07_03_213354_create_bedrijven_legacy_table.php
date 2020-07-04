<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBedrijvenLegacyTable extends Migration
{
    protected $connection = 'francken-legacy';

    /**
     * Run the migrations.
     */
    public function up() : void
    {
        if (Schema::connection('francken-legacy')->hasTable('bedrijven')) {
            return;
        }

        Schema::connection('francken-legacy')->create('bedrijven', function (Blueprint $table) : void {
            $table->increments('id');
            $table->string('naam');
            $table->string('afdeling');
            $table->string('categorie');
            $table->string('adres', 511);
            $table->string('postcode');
            $table->string('plaats');
            $table->string('land');
            $table->string('website');
            $table->string('geslacht');
            $table->string('titel');
            $table->string('initialen');
            $table->string('voornaam');
            $table->string('tussenvoegsel');
            $table->string('achternaam');
            $table->string('functie');
            $table->string('emailadres');
            $table->string('telefoonnummer_werk');
            $table->string('telefoonnummer_mobiel');
            $table->string('faxnummer');
            $table->date('contact_telefoon')->nullable();
            $table->date('contact_email')->nullable();
            $table->date('contact_fax')->nullable();
            $table->date('contact_post')->nullable();
            $table->boolean('mailinglist_constitutiekaart');
            $table->boolean('mailinglist_franckenvrij');
            $table->boolean('mailinglist_jaarverslag');
            $table->text('sponsoring', 65535);
            $table->date('contract_eind')->nullable();
            $table->text('notities', 65535);
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
