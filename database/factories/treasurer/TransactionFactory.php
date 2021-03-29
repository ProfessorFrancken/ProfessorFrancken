<?php

declare(strict_types=1);

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use Francken\Association\LegacyMember;
use Francken\Treasurer\Product;
use Francken\Treasurer\Transaction;

$factory->define(Transaction::class, function (Faker $faker) {
    $price = $faker->randomFloat(2, 0.01, 10.0);

    return [
        "lid_id" => factory(LegacyMember::class),
        "product_id" => factory(Product::class),
        "aantal" => 1,
        "prijs" => $price,
        "totaalprijs" => $price,
        "tijd" => $faker->dateTimeThisDecade,
    ];
});
