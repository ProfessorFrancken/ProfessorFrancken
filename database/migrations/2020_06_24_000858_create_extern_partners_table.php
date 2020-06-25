<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExternPartnersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::create('extern_partners', function (Blueprint $table) : void {
            $table->id();

            $table->bigInteger('sector_id')->unsigned();
            $table->foreign('sector_id')->references('id')->on('extern_partner_sectors');

            $table->string('name');
            $table->string('status');
            $table->string('homepage_url');
            $table->string('referral_url')->nullable();
            $table->string('slug');

            $table->integer('logo_media_id')->unsigned()->nullable();
            $table->foreign('logo_media_id')->references('id')->on('media');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('extern_partners');
    }
}
