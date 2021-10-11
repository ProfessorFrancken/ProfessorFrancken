<?php

declare(strict_types=1);

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use Francken\Association\AlumniActivity\Alumnus;
use Francken\Association\LegacyMember;

$factory->define(Alumnus::class, function (Faker $faker) {
    return [
        "member_id" => factory(LegacyMember::class),
        "fullname" => $faker->name,
        "graduation_year" => $faker->year,
        "study" => $faker->name
    ];
});
