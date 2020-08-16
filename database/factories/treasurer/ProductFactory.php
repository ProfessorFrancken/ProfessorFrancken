<?php

declare(strict_types=1);

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use Francken\Treasurer\Product;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'naam' => $faker->name,
        'prijs' => $faker->randomFloat(),
        'categorie' => $faker->randomElement(['Bier', 'Eten', 'Fris']),
        'positie' => $faker->randomNumber(),
        'beschikbaar' => true,
        'afbeelding' => $faker->word,
        'btw' => $faker->randomFloat(),
        'eenheden' => $faker->randomNumber(),
    ];
});
