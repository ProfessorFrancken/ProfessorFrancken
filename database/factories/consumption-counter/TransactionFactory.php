<?php

declare(strict_types=1);

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use Francken\Association\LegacyMember;
use Francken\Treasurer\Product;
use Francken\Treasurer\Transaction;

$factory->define(Transaction::class, function (Faker $faker) {
    return [
        'lid_id' => factory(LegacyMember::class),
        'product_id' => factory(Product::class),
        'aantal' => $faker->numberBetween(0, 24),
        'prijs' => $faker->numberBetween(1, 1000),
        'totaalprijs' => $faker->numberBetween(1, 1000),
        'tijd' => $faker->dateTime
    ];
});
