<?php

declare(strict_types=1);

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use Plank\Mediable\Media;

$factory->define(Media::class, function (Faker $faker) {
    return [
        'disk' => 'uploads',
        'directory' => 'images/media',
        'filename' => $faker->name,
        'extension' => $faker->fileExtension,
        'mime_type' => $faker->mimeType,
        'aggregate_type' => 'image',
        'size' => $faker->randomDigit,
    ];
});
