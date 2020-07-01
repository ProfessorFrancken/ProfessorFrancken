<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssociationCommitteesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::create('association_committees', function (Blueprint $table) : void {
            $table->id();

            $table->integer('board_id')->unsigned();
            $table->foreign('board_id')->references('id')->on('association_boards');

            $table->bigInteger('parent_committee_id')->unsigned()->nullable();
            $table->foreign('parent_committee_id')->references('id')->on('association_committees');

            $table->integer('logo_media_id')->unsigned()->nullable();
            $table->foreign('logo_media_id')->references('id')->on('media');

            $table->integer('photo_media_id')->unsigned()->nullable();
            $table->foreign('photo_media_id')->references('id')->on('media');

            $table->string('name');
            $table->string('slug');
            $table->string('goal')->nullable();
            $table->string('email')->nullable();
            $table->boolean('is_public');

            $table->text('source_content')->nullable();
            $table->text('compiled_content')->nullable();
            $table->string('fallback_page')->default('association.committees.fallback');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('association_committees');
    }
}
