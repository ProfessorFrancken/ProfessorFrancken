<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTblTentamensLegacyTable extends Migration
{
    protected $connection = 'francken-legacy';

    /**
     * Run the migrations.
     */
    public function up() : void
    {
        if (Schema::connection('francken-legacy')->hasTable('tbl_tentamens')) {
            return;
        }

        Schema::connection('francken-legacy')->create('tbl_tentamens', function (Blueprint $table) : void {
            $table->integer('tentamen_id', true);
            $table->integer('tentamen_vakid');
            $table->dateTime('tentamen_datum');
            $table->text('tentamen_betand', 65535);
            $table->text('tentamen_uitwerking', 65535);
            $table->integer('tentamen_auteurid');
            $table->integer('tentamen_professorid');
            $table->timestamp('tentamen_aanmaak')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }
}
