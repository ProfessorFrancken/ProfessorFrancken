<?php

declare(strict_types=1);

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use Francken\Association\Activities\Activity;
use Francken\Association\Activities\SignUp;
use Francken\Association\LegacyMember;

$factory->define(SignUp::class, function (Faker $faker) {
    return [
        'activity_id' => factory(Activity::class),
        'member_id' => factory(LegacyMember::class),
        'plus_ones' => $faker->numberBetween(0, 4),
        'dietary_wishes' => $faker->text,
        'has_drivers_license' => $faker->boolean,
        'notes' => $faker->text,
    ];
});
