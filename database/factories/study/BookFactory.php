<?php

declare(strict_types=1);

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use Francken\Association\LegacyMember;
use Francken\Study\BooksSale\Book;

$factory->define(Book::class, function (Faker $faker) {
    $takenInBySellerAt = $faker->dateTime;
    $wasSold = $faker->boolean(30);

    $takenInByBuyerAt = $wasSold
        ? $faker->dateTimeBetween(
            $takenInBySellerAt,
            $takenInBySellerAt->modify('+3 years')
        )
        : null;

    return [
        'title' => $faker->sentence(4),
        'edition' => $faker->numberBetween(0, 5),
        'author' => $faker->name,
        'description' => $faker->paragraph(3),
        'isbn' => $faker->isbn13,
        'price' => $faker->numberBetween(100, 5000),
        'cover_url' => $faker->imageUrl(100, 300),

        'seller_id' => factory(LegacyMember::class),
        'buyer_id' => $wasSold ? factory(LegacyMember::class) : null,

        'taken_in_from_seller_at' => $takenInBySellerAt,
        'taken_in_by_buyer_at' => $takenInByBuyerAt,

        'has_been_sold' => $wasSold,
        'paid_off' => $wasSold && $faker->boolean(30),
    ];
});
