<?php

declare(strict_types=1);

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use Francken\Association\Borrelcie\Anytimer;
use Francken\Association\Borrelcie\BorrelcieAccount;

$factory->define(Anytimer::class, function (Faker $faker) {
    return [
        'drinker_id' => factory(BorrelcieAccount::class),
        'owner_id' => factory(BorrelcieAccount::class),
        'accepted' => $faker->boolean,
        'context' => $faker->randomElement([
            'given', 'claimed', 'used', 'drank'
        ]),
        'reason' => $faker->paragraph,
        'amount' => function (array $anytimer) use ($faker) {
            return in_array($anytimer['context'], ['used', 'drank'], true)
                ? -$faker->numberBetween(1, 5)
                : $faker->numberBetween(1, 5);
        },
    ];
});

$factory->state(Anytimer::class, 'given', [
    'context' => 'given',
]);

$factory->state(Anytimer::class, 'claimed', [
    'context' => 'claimed',
]);

$factory->state(Anytimer::class, 'used', [
    'context' => 'used',
]);

$factory->state(Anytimer::class, 'drank', [
    'context' => 'drank',
]);
