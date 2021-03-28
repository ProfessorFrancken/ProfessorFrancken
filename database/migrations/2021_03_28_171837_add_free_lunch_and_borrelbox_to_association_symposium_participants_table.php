<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFreeLunchAndBorrelboxToAssociationSymposiumParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('association_symposium_participants', function (Blueprint $table) {
            $table->boolean('free_lunch')->default(false);
            $table->boolean('free_borrelbox')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('association_symposium_participants', function (Blueprint $table) {
            $table->dropColumn('free_lunch');
        });
        Schema::table('association_symposium_participants', function (Blueprint $table) {
            $table->dropColumn('free_borrelbox');
        });
    }
}
