<?php

declare(strict_types=1);

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use Francken\Shared\Page;

$factory->define(Page::class, function (Faker $faker) {
    return [
        'title' => $faker->name,
        'slug' => $faker->slug,
        'description' => $faker->paragraph,
        'source_content' => $faker->text,
        'compiled_content' => $faker->text,
        'is_published' => $faker->boolean,
    ];
});
