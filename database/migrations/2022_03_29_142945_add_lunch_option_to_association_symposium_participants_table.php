<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLunchOptionToAssociationSymposiumParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('association_symposium_participants', function (Blueprint $table) {
            $table->string('lunch_option')->nullable()->default(null);
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
            $table->dropColumn('lunch_option');
        });
    }
}
