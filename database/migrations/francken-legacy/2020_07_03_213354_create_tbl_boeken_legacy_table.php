<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblBoekenLegacyTable extends Migration
{
    protected $connection = 'francken-legacy';

    /**
     * Run the migrations.
     */
    public function up() : void
    {
        if (Schema::connection('francken-legacy')->hasTable('tbl_boeken')) {
            return;
        }

        Schema::connection('francken-legacy')->create('tbl_boeken', function (Blueprint $table) : void {
            $table->integer('id', true);
            $table->text('boek_naam', 65535);
            $table->text('boek_isbn', 65535);
            $table->text('boek_auteur', 65535);
            $table->integer('boek_vakid');
            $table->integer('boek_verkoperid');
            $table->integer('boek_koperid');
            $table->integer('boek_prijs');
            $table->text('boek_beschrijving', 65535);
            $table->dateTime('boek_inkoopdatum');
            $table->dateTime('boek_verkoopdatum');
            $table->text('boek_link', 65535);
        });
    }
}
