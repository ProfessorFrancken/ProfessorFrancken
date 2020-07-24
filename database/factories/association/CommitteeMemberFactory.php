<?php

declare(strict_types=1);

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use Francken\Association\Committees\Committee;
use Francken\Association\Committees\CommitteeMember;
use Francken\Association\LegacyMember;

$factory->define(CommitteeMember::class, function (Faker $faker) {
    return [
        'member_id' => factory(LegacyMember::class),
        'committee_id' => factory(Committee::class),

        'function' => $faker->word,
        'installed_at' => $faker->dateTime,
        'decharged_at' => $faker->dateTime,
    ];
});

