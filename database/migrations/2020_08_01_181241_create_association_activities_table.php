<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssociationActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::create('association_activities', function (Blueprint $table) : void {
            $table->id();
            $table->string('google_calendar_uid');

            $table->string('name');
            $table->string('slug');
            $table->string('summary');
            $table->text('source_content');
            $table->text('compiled_content');

            $table->string('location');

            $table->dateTime('start_date');
            $table->dateTime('end_date');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('association_activities');
    }
}
