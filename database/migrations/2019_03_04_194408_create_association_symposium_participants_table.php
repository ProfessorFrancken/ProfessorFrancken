<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssociationSymposiumParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::create('association_symposium_participants', function (Blueprint $table) : void {
            $table->increments('id');
            $table->unsignedInteger('symposium_id');
            $table->unsignedInteger('member_id')->nullable();

            $table->string('firstname');
            $table->string('lastname');
            $table->string('email');
            $table->boolean('is_francken_member');
            $table->boolean('is_nnv_member');
            $table->string('nnv_number')->nullable();
            $table->boolean('pays_with_iban')->default(true);
            $table->string('iban')->nullable();
            $table->boolean('has_registration')->default(false);
            $table->boolean('has_paid')->default(false);

            $table->datetime('email_verified_at')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('association_symposium_participants');
    }
}
