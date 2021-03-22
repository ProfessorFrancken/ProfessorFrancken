<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssociationFranckenVrijSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('association_francken_vrij_subscriptions', function (Blueprint $table) {
            $table->id();

            $table->integer('member_id')->unsigned();
            $table->dateTime('subscription_ends_at')->nullable();

            $table->boolean('send_expiration_notification');
            $table->dateTime('notified_at')->nullable();

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
        Schema::dropIfExists('association_francken_vrij_subscriptions');
    }
}
