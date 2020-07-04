<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBoekenLegacyTable extends Migration
{
    protected $connection = 'francken-legacy';

    /**
     * Run the migrations.
     */
    public function up() : void
    {
        if (Schema::connection('francken-legacy')->hasTable('boeken')) {
            return;
        }

        Schema::connection('francken-legacy')->create('boeken', function (Blueprint $table) : void {
            $table->integer('id', true);
            $table->text('naam', 65535)->nullable();
            $table->integer('editie')->nullable();
            $table->text('isbn', 65535)->nullable();
            $table->text('auteur', 65535)->nullable();
            $table->integer('vakid')->nullable();
            $table->integer('verkoperid')->nullable();
            $table->integer('koperid')->nullable();
            $table->integer('prijs')->nullable();
            $table->text('beschrijving', 65535)->nullable();
            $table->dateTime('inkoopdatum')->nullable();
            $table->dateTime('verkoopdatum')->nullable();
            $table->text('link', 65535)->nullable();
            $table->boolean('afgerekend')->nullable()->default(0);
            $table->boolean('verkocht')->nullable()->default(0);
        });
    }
}
