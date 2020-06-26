<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExternVacanciesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::create('extern_partner_vacancies', function (Blueprint $table) : void {
            $table->id();

            $table->bigInteger('partner_id')->unsigned();
            $table->foreign('partner_id')->references('id')->on('extern_partners');

            $table->bigInteger('sector_id')->unsigned();
            $table->foreign('sector_id')->references('id')->on('extern_partner_sectors');

            $table->string('type');
            $table->string('title');
            $table->text('description');
            $table->string('vacancy_url');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('extern_partner_vacancies');
    }
}
