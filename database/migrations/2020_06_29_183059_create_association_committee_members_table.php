<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssociationCommitteeMembersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::create('association_committee_members', function (Blueprint $table) : void {
            $table->id();

            $table->integer('member_id')->unsigned();

            $table->bigInteger('committee_id')->unsigned();
            $table->foreign('committee_id')->references('id')->on('association_committees');

            $table->string('function')->nullable();
            $table->dateTime('installed_at');
            $table->dateTime('decharged_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('association_committee_members');
    }
}
