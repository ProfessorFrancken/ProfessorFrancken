<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommitteesListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('committees_list', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('name');
            $table->string('summary');
            $table->string('email');
            $table->string('markDown');
            $table->string('html');
            $table->json('members');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('committees_list');
    }
}
