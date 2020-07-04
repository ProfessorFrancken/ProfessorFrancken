<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblsamenvattingenLegacyTable extends Migration
{
    protected $connection = 'francken-legacy';

    /**
     * Run the migrations.
     */
    public function up() : void
    {
        if (Schema::connection('francken-legacy')->hasTable('tblsamenvattingen')) {
            return;
        }

        Schema::connection('francken-legacy')->create('tblsamenvattingen', function (Blueprint $table) : void {
            $table->integer('sammenvatting_id', true);
            $table->integer('sammenvatting_vakid');
            $table->integer('sammenvatting_auteurid');
            $table->text('sammenvatting_bestand', 65535);
            $table->integer('sammenvatting_jaar');
            $table->integer('sammenvatting_professorid');
            $table->timestamp('sammenvatting_aanmaak')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }
}
