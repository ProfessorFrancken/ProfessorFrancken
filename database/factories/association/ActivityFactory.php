<?php

declare(strict_types=1);

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use Francken\Association\Activities\Activity;
use Illuminate\Support\Str;

$factory->define(Activity::class, function (Faker $faker) {
    $startDate = $faker->dateTime;
    $content = $faker->paragraph;
    $name = $faker->text;

    return [
        'name' => $name,
        'slug' => sprintf(
            "%s-%s",
            $startDate->format('Y-m-d'),
            Str::slug($name)
        ),
        'summary' => Str::limit($content, 80),
        'source_content' => $content,
        'compiled_content' => $content,
        'location' => $faker->city,
        'start_date' => $startDate,
        'end_date' => $faker->dateTimeBetween(
            $startDate,
            (clone $startDate)->modify('+1 day')
        ),
        'google_calendar_uid' => $faker->text
    ];
});
