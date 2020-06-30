<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBoardBoardYearSlugToAssociationBoardsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('association_boards', function (Blueprint $table) {
            $table->string('board_year_slug')->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('association_boards', function (Blueprint $table) {
            $table->removeColumn('board_year_slug');
        });
    }
}
