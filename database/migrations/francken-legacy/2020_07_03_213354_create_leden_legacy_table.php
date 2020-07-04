<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLedenLegacyTable extends Migration
{
    protected $connection = 'francken-legacy';

    /**
     * Run the migrations.
     */
    public function up() : void
    {
        if (Schema::connection('francken-legacy')->hasTable('leden')) {
            return;
        }

        Schema::connection('francken-legacy')->create('leden', function (Blueprint $table) : void {
            $table->increments('id');
            $table->string('geslacht')->nullable();
            $table->string('titel')->nullable();
            $table->string('initialen')->nullable();
            $table->string('voornaam')->nullable();
            $table->string('tussenvoegsel')->nullable();
            $table->string('achternaam');
            $table->date('geboortedatum')->nullable();
            $table->string('foto')->nullable();
            $table->boolean('nederlands')->nullable()->default(1);
            $table->string('adres', 511)->nullable();
            $table->string('postcode')->nullable();
            $table->string('plaats')->nullable()->default('Groningen');
            $table->string('land')->nullable();
            $table->boolean('is_nederland')->nullable()->default(1);
            $table->string('emailadres')->nullable();
            $table->string('telefoonnummer_thuis')->nullable();
            $table->string('telefoonnummer_werk')->nullable();
            $table->string('telefoonnummer_mobiel')->nullable();
            $table->string('rekeningnummer')->nullable();
            $table->string('plaats_bank')->nullable();
            $table->boolean('machtiging')->nullable();
            $table->boolean('wanbetaler')->nullable();
            $table->boolean('gratis_lidmaatschap')->nullable();
            $table->date('start_lidmaatschap')->nullable();
            $table->date('einde_lidmaatschap')->nullable();
            $table->boolean('is_lid')->nullable()->default(1);
            $table->string('type_lid')->nullable();
            $table->string('studentnummer')->nullable();
            $table->string('studierichting')->nullable();
            $table->string('jaar_van_inschrijving')->nullable();
            $table->string('afstudeerplek')->nullable();
            $table->boolean('afgestudeerd')->nullable();
            $table->string('werkgever')->nullable();
            $table->string('nnvnummer')->nullable();
            $table->string('streeplijst')->nullable();
            $table->boolean('mailinglist_email')->nullable()->default(1);
            $table->boolean('mailinglist_post')->nullable()->default(1);
            $table->boolean('mailinglist_sms')->nullable()->default(1);
            $table->boolean('mailinglist_constitutiekaart')->nullable()->default(1);
            $table->boolean('mailinglist_franckenvrij')->nullable()->default(1);
            $table->boolean('erelid')->nullable();
            $table->text('notities', 65535)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
