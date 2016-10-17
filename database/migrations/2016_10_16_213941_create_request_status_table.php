<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_status', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('requestee');

            $table->boolean('hasPersonalInfo');
            $table->boolean('hasContactInfo');
            $table->boolean('hasStudyInfo');
            $table->boolean('hasPaymentInfo');

            $table->datetime('submittedAt');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('request_status');
    }
}
