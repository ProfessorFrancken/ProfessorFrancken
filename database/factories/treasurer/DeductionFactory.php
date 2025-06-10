<?php

declare(strict_types=1);

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use Francken\Treasurer\Deduction;

$factory->define(Deduction::class, function (Faker $faker) {
    return [
        "tijd" => $faker->dateTimeThisDecade,
    ];
});
