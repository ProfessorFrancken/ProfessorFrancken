<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::create('members_registrations', function (Blueprint $table) : void {
            $table->bigIncrements('id');

            $table->string('firstname');
            $table->string('surname');
            $table->string('initials');
            $table->string('gender');
            $table->date('birthdate');

            $table->boolean('has_dutch_diploma');
            $table->string('nationality');

            $table->string('email');

            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('country')->nullable();
            $table->string('phone_number')->nullable();
            
            $table->string('student_number');
            $table->json('studies');

            $table->string('iban')->nullable();
            $table->string('bic')->nullable();
            $table->boolean('deduct_additional_costs');

            $table->text('comments');
            $table->boolean('wants_to_join_a_committee');

            $table->datetime('email_verified_at')->nullable();
            $table->datetime('registration_accepted_at')->nullable();
            $table->datetime('registration_form_signed_at')->nullable();

            $table->unsignedInteger('member_id')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('members_registrations');
    }
}
