<?php

declare(strict_types=1);

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use Francken\Treasurer\Product;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'naam' => $faker->word,
        'prijs' => $faker->randomFloat(),
        'categorie' => $faker->word,
        'positie' => $faker->randomNumber(),
        'beschikbaar' => $faker->boolean,
        'afbeelding' => $faker->word,
        'btw' => $faker->randomFloat(),
        'eenheden' => $faker->randomNumber(),
    ];
});
