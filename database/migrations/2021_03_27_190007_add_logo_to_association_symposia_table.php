<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLogoToAssociationSymposiaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('association_symposia', function (Blueprint $table) {
            $table->integer('logo_media_id')->unsigned()->nullable();
            $table->foreign('logo_media_id')->references('id')->on('media');

            $table->string('location_google_maps_url')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Since our tests use sqlite and run down migrations we can't drop the foreign keys
        // This is quite an ugly hack
        try {
            Schema::table('association_symposia', function (Blueprint $table) {
                $table->dropForeign('association_symposia_logo_media_id_foreign');
            });
        } catch (\Exception $e) {} finally {
            Schema::table('association_symposia', function (Blueprint $table) {
                $table->dropColumn('logo_media_id');
            });
            Schema::table('association_symposia', function (Blueprint $table) {
                $table->dropColumn('location_google_maps_url');
            });
        }
    }
}
