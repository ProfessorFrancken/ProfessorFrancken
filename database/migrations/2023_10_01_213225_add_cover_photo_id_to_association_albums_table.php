<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('association_albums', function (Blueprint $table) {
            $table->bigInteger('cover_photo_id')->unsigned()->nullable();
            $table->foreign('cover_photo_id')->references('id')->on('association_photos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('association_albums', function (Blueprint $table) {
            if (DB::getDriverName() !== 'sqlite') {
                $table->dropForeign(['cover_photo_id']);
            }
            $table->dropColumn('cover_photo_id');
        });
    }
};
