<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssociationAlumniActivity2022AlumniTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('association_alumni_activity_2022_alumni', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('member_id')->nullable();
            $table->string('fullname');
            $table->string('study');
            $table->integer('graduation_year')->nullable();
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
        Schema::dropIfExists('association_alumni_activity_2022_alumni');
    }
}
