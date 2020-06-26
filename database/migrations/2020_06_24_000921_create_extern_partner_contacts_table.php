<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExternPartnerContactsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::create('extern_partner_contacts', function (Blueprint $table) : void {
            $table->id();

            $table->bigInteger('partner_id')->unsigned();
            $table->foreign('partner_id')->references('id')->on('extern_partners');

            $table->string('gender');
            $table->string('title');
            $table->string('initials');
            $table->string('firstname');
            $table->string('surname');
            $table->string('position');
            $table->string('email');
            $table->string('phone_number');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('extern_partner_contacts');
    }
}
