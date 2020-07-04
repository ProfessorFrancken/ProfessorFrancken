<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateZusterverenigingenLegacyTable extends Migration
{
    protected $connection = 'francken-legacy';

    /**
     * Run the migrations.
     */
    public function up() : void
    {
        if (Schema::connection('francken-legacy')->hasTable('zusterverenigingen')) {
            return;
        }

        Schema::connection('francken-legacy')->create('zusterverenigingen', function (Blueprint $table) : void {
            $table->increments('id');
            $table->string('naam');
            $table->string('studies', 511);
            $table->string('adres', 511);
            $table->string('postcode');
            $table->string('plaats');
            $table->string('land');
            $table->string('emailadres');
            $table->string('telefoonnummer');
            $table->string('faxnummer');
            $table->string('website');
            $table->boolean('actief_contact');
            $table->boolean('mailinglist_constitutiekaart');
            $table->boolean('mailinglist_franckenvrij');
            $table->boolean('fvoglid');
            $table->date('constitutiedatum')->nullable();
            $table->text('notities', 65535);
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
