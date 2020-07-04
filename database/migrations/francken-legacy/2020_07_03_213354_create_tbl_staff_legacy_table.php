<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblStaffLegacyTable extends Migration
{
    protected $connection = 'francken-legacy';

    /**
     * Run the migrations.
     */
    public function up() : void
    {
        if (Schema::connection('francken-legacy')->hasTable('tbl_staff')) {
            return;
        }

        Schema::connection('francken-legacy')->create('tbl_staff', function (Blueprint $table) : void {
            $table->integer('staff_id', true);
            $table->text('staff_voornaam', 65535);
            $table->text('staff_tussenvoegsel', 65535);
            $table->text('staff_achternaam', 65535);
            $table->text('staff_titel', 65535);
            $table->integer('staff_lidid');
            $table->integer('staff_vakgroep');
            $table->integer('staff_functie');
        });
    }
}
