<?php

declare(strict_types=1);

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use Francken\Association\Photos\Album;

$factory->define(Album::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'description' => $faker->paragraph,
        'slug' => $faker->slug,
        'visibility' => $faker->randomElement([
            'private', 'public', 'members-only'
        ]),
        'published_at' => $faker->dateTimeThisYear,
        'disk' => 'nextcloud',
        'path' => '',
    ];
});
