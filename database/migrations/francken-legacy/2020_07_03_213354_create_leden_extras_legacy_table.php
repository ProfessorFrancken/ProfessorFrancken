<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLedenExtrasLegacyTable extends Migration
{
    protected $connection = 'francken-legacy';

    /**
     * Run the migrations.
     */
    public function up() : void
    {
        if (Schema::connection('francken-legacy')->hasTable('leden_extras')) {
            return;
        }

        Schema::connection('francken-legacy')->create('leden_extras', function (Blueprint $table) : void {
            $table->integer('lid_id')->primary();
            $table->integer('prominent')->nullable()->comment('prominentindex');
            $table->string('kleur', 9)->nullable()->comment('kleur in hexcode');
            $table->string('afbeelding')->nullable();
            $table->string('bijnaam')->nullable();
            $table->integer('button_width')->default(0);
            $table->integer('button_height')->default(0);
        });
    }
}
