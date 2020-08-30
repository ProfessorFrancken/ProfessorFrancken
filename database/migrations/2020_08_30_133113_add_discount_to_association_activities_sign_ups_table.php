<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDiscountToAssociationActivitiesSignUpsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::table('association_activities_sign_ups', function (Blueprint $table) {
            $table->integer('discount')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('association_activities_sign_ups', function (Blueprint $table) {
            $table->removeColumn('discount');
        });
    }
}
