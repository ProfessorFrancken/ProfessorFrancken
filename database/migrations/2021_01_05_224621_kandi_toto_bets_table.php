<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KandiTotoBetsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('board_kandi_toto_bets', function (Blueprint $table) : void {
            $table->increments('id');

            $table->integer('member_id')->unsigned()->nullable();
            $table->integer('board_year');

            $table->text('president');
            $table->text('secretary');
            $table->text('treasurer');
            $table->text('intern');
            $table->text('extern');
            $table->text('wildcard');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('board_kandi_toto_bets');
    }
}
