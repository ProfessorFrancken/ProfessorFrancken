<?php

declare(strict_types=1);

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use Francken\Association\Boards\Board;
use Francken\Association\Committees\Committee;

$factory->define(Committee::class, function (Faker $faker) {
    return [
        'board_id' => factory(Board::class),
        'parent_committee_id' => null,
        'logo_media_id' => null, // factory(Plank\Mediable\Media::class),
        'photo_media_id' => null, //factory(Plank\Mediable\Media::class),
        'name' => $faker->name,
        'slug' => $faker->slug,
        'email' => $faker->safeEmail,
        'is_public' => $faker->boolean,
        'source_content' => $faker->text,
        'compiled_content' => $faker->text,
        'fallback_page' => 'association.committees.fallback',
        'goal' => $faker->word,
    ];
});
