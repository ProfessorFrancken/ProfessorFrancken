<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTreasurerDeductionEmailToMembersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::create('treasurer_deduction_email_to_members', function (Blueprint $table) : void {
            $table->increments('id');

            $table->integer('member_id')->unsigned();
            $table->integer('deduction_email_id')->unsigned();
            $table->unique(
                ['member_id', 'deduction_email_id'],
                'treasurer_deduction_emails_member_deduction_unique'
            );
            $table->foreign('deduction_email_id')
                ->references('id')
                ->on('treasurer_deduction_emails');

            $table->text('description');
            $table->integer('amount_in_cents')->unsigned();
            $table->boolean('contained_errors');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('treasurer_deduction_email_to_members');
    }
}
