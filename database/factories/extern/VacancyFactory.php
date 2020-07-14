<?php

declare(strict_types=1);

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use Francken\Extern\Partner;
use Francken\Extern\SponsorOptions\Vacancy;

$factory->define(Vacancy::class, function (Faker $faker) {
    return [
        'partner_id' => factory(Partner::class),
        'sector_id' => $faker->randomNumber(),
        'type' => $faker->word,
        'title' => $faker->word,
        'description' => $faker->text,
        'vacancy_url' => $faker->word,
        'deleted_at' => $faker->dateTime(),
    ];
});
