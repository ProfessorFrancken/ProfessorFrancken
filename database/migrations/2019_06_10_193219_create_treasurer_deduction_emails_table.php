<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTreasurerDeductionEmailsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        // This table is used to keep track on whether we have send an email
        // informing our members about an upcoming deduction
        Schema::create('treasurer_deduction_emails', function (Blueprint $table) : void {
            $table->increments('id');

            $table->integer('amount_of_members')->unsigned();
            $table->date('deduction_from');
            $table->date('deduction_to');
            $table->date('deducted_at');
            $table->date('emails_sent_at')->nullable();
            $table->boolean('was_verified');

            // We store the file associated to the deduction as a media object
            $table->integer('file_media_id')->unsigned();
            $table->foreign('file_media_id')->references('id')->on('media');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('treasurer_deduction_emails');
    }
}
