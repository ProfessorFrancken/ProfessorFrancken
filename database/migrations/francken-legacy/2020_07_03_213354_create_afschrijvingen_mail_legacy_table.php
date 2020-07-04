<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAfschrijvingenMailLegacyTable extends Migration
{
    protected $connection = 'francken-legacy';

    /**
     * Run the migrations.
     */
    public function up() : void
    {
        if (Schema::connection('francken-legacy')->hasTable('afschrijvingen_mail')) {
            return;
        }

        Schema::connection('francken-legacy')->create('afschrijvingen_mail', function (Blueprint $table) : void {
            $table->integer('id', true);
            $table->integer('aantalleden')->nullable();
            $table->string('bestand')->nullable();
            $table->date('datum')->nullable();
        });
    }
}
