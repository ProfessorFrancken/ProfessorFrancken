<?php

declare(strict_types=1);

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use Francken\Association\FranckenVrij\Subscription;
use Francken\Association\LegacyMember;

$factory->define(Subscription::class, function (Faker $faker) {
    return [
        'member_id' => factory(LegacyMember::class),
        'subscription_ends_at' => $faker->optional(0.1)->dateTimeInInterval('-3 year', '+5 years'),
        'send_expiration_notification' => $faker->boolean,
        'notified_at' => $faker->optional()->dateTimeThisYear,
    ];
});
