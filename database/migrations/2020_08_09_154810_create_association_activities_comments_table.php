<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssociationActivitiesCommentsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('association_activities_comments', function (Blueprint $table) {
            $table->id();

            $table->integer('member_id')->unsigned();

            $table->bigInteger('activity_id')->unsigned();
            $table->foreign('activity_id')->references('id')->on('association_activities');

            $table->text('content');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('association_activities_comments');
    }
}
