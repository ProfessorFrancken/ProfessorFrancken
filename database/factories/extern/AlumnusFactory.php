<?php

declare(strict_types=1);

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use Francken\Association\LegacyMember;
use Francken\Extern\Alumnus;
use Francken\Extern\Partner;

$factory->define(Alumnus::class, function (Faker $faker) {
    return [
        'member_id' => factory(LegacyMember::class),
        'partner_id' => factory(Partner::class),
        'position' => $faker->word,
        'started_position_at' => $faker->dateTime(),
        'stopped_position_at' => $faker->dateTime(),
        'notes' => $faker->text,
    ];
});
