<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExternPartnerContactDetails extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::create('extern_partner_contact_details', function (Blueprint $table) : void {
            $table->id();

            $table->bigInteger('partner_id')->unsigned();
            $table->foreign('partner_id')->references('id')->on('extern_partners');

            // Can either be directly related to the partner (null, or to a contact of the partner)
            $table->bigInteger('contact_id')->unsigned()->nullable();
            $table->foreign('contact_id')->references('id')->on('extern_partner_contacts');

            $table->unique(['partner_id', 'contact_id']);

            $table->string('email')->nullable();
            $table->string('phone_number')->nullable();

            $table->string('department')->nullable();
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('country')->nullable();

            $table->boolean('should_receive_francken_vrij')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('extern_partner_addresses');
    }
}
