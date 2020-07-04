<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTellingenLegacyTable extends Migration
{
    protected $connection = 'francken-legacy';

    /**
     * Run the migrations.
     */
    public function up() : void
    {
        if (Schema::connection('francken-legacy')->hasTable('tellingen')) {
            return;
        }

        Schema::connection('francken-legacy')->create('tellingen', function (Blueprint $table) : void {
            $table->integer('id', true);
            $table->date('datum');
            $table->text('notities', 65535)->nullable();
            $table->timestamps();
        });
    }
}
