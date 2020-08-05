<?php

declare(strict_types=1);

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use Francken\Association\Activities\Activity;
use Francken\Association\Activities\SignUpSettings;

$factory->define(SignUpSettings::class, function (Faker $faker) {
    return [
        'activity_id' => factory(Activity::class),
        'max_sign_ups' => $faker->randomNumber(2),
        'costs_per_person' => $faker->randomNumber(4),
        'max_plus_ones_per_member' => $faker->randomNumber(2),
        'ask_for_dietary_wishes'=> $faker->boolean,
        'ask_for_drivers_license'=> $faker->boolean,
        'deadline_at' => $faker->dateTime,
    ];
});

