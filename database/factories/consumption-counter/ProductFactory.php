<?php

declare(strict_types=1);

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use Francken\Treasurer\Product;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'naam' => $faker->name,
        'prijs' => $faker->numberBetween(0, 1000),
        'positie' => $faker->numberBetween(0, 999),
        'categorie' => $faker->randomElement([
            'Bier',
            'Fris',
            'Eten'
        ]),
        'beschikbaar' => $faker->boolean,
        'afbeelding' => $faker->imageUrl(100, 100),
        'btw' => 0.21,
        'eenheden' => 1,
    ];
});
