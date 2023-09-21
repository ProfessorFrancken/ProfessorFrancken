<?php

declare(strict_types=1);

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use Francken\Association\Photos\Album;
use Francken\Association\Photos\Photo;

$factory->define(Photo::class, function (Faker $faker) {
    return [
        'album_id' => factory(Album::class),
        'name' => $faker->name,
        'path' => '',
        'visibility' => $faker->randomElement([
            'private', 'public', 'members-only'
        ]),
    ];
});
