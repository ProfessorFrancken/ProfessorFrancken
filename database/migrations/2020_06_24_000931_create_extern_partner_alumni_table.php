<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExternPartnerAlumniTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::create('extern_partner_alumni', function (Blueprint $table) : void {
            $table->id();

            $table->integer('member_id')->unsigned();

            $table->bigInteger('partner_id')->unsigned();
            $table->foreign('partner_id')->references('id')->on('extern_partners');

            $table->string('position')->nullable();
            $table->dateTime('started_position_at')->nullable();
            $table->dateTime('stopped_position_at')->nullable();
            $table->text('notes')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('extern_partner_alumni');
    }
}
