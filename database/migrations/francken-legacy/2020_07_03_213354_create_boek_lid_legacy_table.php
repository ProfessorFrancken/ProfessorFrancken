<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBoekLidLegacyTable extends Migration
{
    protected $connection = 'francken-legacy';

    /**
     * Run the migrations.
     */
    public function up() : void
    {
        if (Schema::connection('francken-legacy')->hasTable('boek_lid')) {
            return;
        }

        Schema::connection('francken-legacy')->create('boek_lid', function (Blueprint $table) : void {
            $table->integer('id', true);
            $table->integer('boek_id');
            $table->integer('lid_id');
            $table->timestamps();
            $table->dateTime('deleted_at');
        });
    }
}
