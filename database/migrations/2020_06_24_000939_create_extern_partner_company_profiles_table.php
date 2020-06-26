<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExternPartnerCompanyProfilesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::create('extern_partner_company_profiles', function (Blueprint $table) : void {
            $table->id();

            $table->bigInteger('partner_id')->unsigned();
            $table->foreign('partner_id')->references('id')->on('extern_partners');

            $table->string('display_name')->nullable();
            $table->text('source_content');
            $table->text('compiled_content');

            $table->boolean('is_enabled')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('extern_partner_company_profiles');
    }
}
