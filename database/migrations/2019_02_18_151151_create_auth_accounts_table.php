<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthAccountsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::create('auth_accounts', function (Blueprint $table) : void {
            $table->increments('id');

            $table->string('email')->unique();
            $table->string('password');
            $table->integer('member_id')->unique();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('auth_accounts');
    }
}
