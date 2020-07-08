<?php

declare(strict_types=1);

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use Francken\Extern\Sector;

$factory->define(Sector::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'icon' => $faker->word,
    ];
});
