<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsSpamAndReceivedInformationMailToParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::table('association_symposium_participants', function (Blueprint $table) : void {
            $table->boolean('is_spam')->default(false);
            $table->boolean('received_information_mail')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::table('association_symposium_participants', function (Blueprint $table) : void {
            $table->dropColumn('is_spam');
            $table->dropColumn('received_information_mail');
        });
    }
}
