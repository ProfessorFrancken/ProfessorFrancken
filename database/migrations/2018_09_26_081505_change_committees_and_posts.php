<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeCommitteesAndPosts extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::table('posts', function (Blueprint $table) : void {
            $table->text('content')->change();
        });

        Schema::table('committees_list', function (Blueprint $table) : void {
            $table->text('markdown')->change();
            $table->text('html')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::table('posts', function (Blueprint $table) : void {
            $table->string('content')->change();
        });

        Schema::table('committees_list', function (Blueprint $table) : void {
            $table->string('markdown')->change();
            $table->string('html')->change();
        });
    }
}
