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

            $table->integer('photo_media_id')->unsigned()->nullable();
            $table->foreign('photo_media_id')->references('id')->on('media');

            $table->string('gender')->nullable();
            $table->string('title')->nullable();
            $table->string('initials')->nullable();
            $table->string('firstname');
            $table->string('surname');
            $table->string('position')->nullable();

            $table->string('notes')->nullable();

            $table->softDeletes();
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
