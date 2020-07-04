<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblVakkenLegacyTable extends Migration
{
    protected $connection = 'francken-legacy';

    /**
     * Run the migrations.
     */
    public function up() : void
    {
        if (Schema::connection('francken-legacy')->hasTable('tbl_vakken')) {
            return;
        }

        Schema::connection('francken-legacy')->create('tbl_vakken', function (Blueprint $table) : void {
            $table->integer('id', true);
            $table->text('vak_naam', 65535);
            $table->integer('vak_professorid');
            $table->boolean('vak_studiejaar');
            $table->integer('vak_periode');
            $table->integer('vak_academischjaar');
            $table->boolean('vak_studie');
            $table->text('vak_codeocasys', 65535);
            $table->integer('vak_omschrijving');
            $table->boolean('vak_img');
            $table->text('vak_boek', 65535);
            $table->timestamp('vak_aanmaak')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
