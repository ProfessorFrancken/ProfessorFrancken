<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLeveranciersLegacyTable extends Migration
{
    protected $connection = 'francken-legacy';

    /**
     * Run the migrations.
     */
    public function up() : void
    {
        if (Schema::connection('francken-legacy')->hasTable('leveranciers')) {
            return;
        }

        Schema::connection('francken-legacy')->create('leveranciers', function (Blueprint $table) : void {
            $table->integer('id', true);
            $table->string('naam');
            $table->string('adres')->nullable();
            $table->string('postcode')->nullable();
            $table->string('plaats')->nullable();
            $table->string('telefoonnummer')->nullable();
            $table->string('emailadres')->nullable();
            $table->string('website')->nullable();
            $table->text('notities', 65535)->nullable();
            $table->timestamps();
        });
    }
}
