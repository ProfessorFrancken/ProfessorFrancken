<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssociationBoardMembersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::create('association_board_members', function (Blueprint $table) : void {
            $table->increments('id');

            $table->integer('board_id')->unsigned();
            $table->foreign('board_id')->references('id')->on('association_boards');

            $table->integer('member_id')->unsigned()->nullable();
            $table->string('title');
            $table->string('name');

            $table->string('board_member_status');
            $table->date('installed_at');
            $table->date('demissioned_at')->nullable();
            $table->date('decharged_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('association_board_members');
    }
}
