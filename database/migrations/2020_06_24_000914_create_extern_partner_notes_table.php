<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExternPartnerNotesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::dropIfExists('extern_partner_notes');
        Schema::create('extern_partner_notes', function (Blueprint $table) : void {
            $table->id();

            $table->bigInteger('partner_id')->unsigned();
            $table->foreign('partner_id')->references('id')->on('extern_partners');

            $table->string('note');
            $table->integer('member_id')->unsigned();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('extern_partner_notes');
    }
}
