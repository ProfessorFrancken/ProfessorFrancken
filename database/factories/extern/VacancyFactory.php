<?php

declare(strict_types=1);

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use Francken\Extern\JobType;
use Francken\Extern\Partner;
use Francken\Extern\Sector;
use Francken\Extern\SponsorOptions\Vacancy;

$factory->define(Vacancy::class, function (Faker $faker) {
    return [
        'partner_id' => factory(Partner::class),
        'sector_id' => factory(Sector::class),
        'type' => $faker->randomElement(
            array_keys(JobType::TYPES)
        ),
        'title' => $faker->text,
        'description' => $faker->text,
        'vacancy_url' => $faker->url,
        'deleted_at' => $faker->dateTime(),
    ];
});
