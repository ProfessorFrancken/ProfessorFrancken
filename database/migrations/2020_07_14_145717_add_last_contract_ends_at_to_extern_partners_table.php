<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLastContractEndsAtToExternPartnersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::table('extern_partners', function (Blueprint $table) {
            $table->date('last_contract_ends_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('extern_partners', function (Blueprint $table) {
            $table->dropColumn('last_contract_ends_at');
        });
    }
}
