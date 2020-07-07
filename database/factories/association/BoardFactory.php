<?php

declare(strict_types=1);

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use Francken\Association\Boards\Board;

/**
 * @example
 * factory(Francken\Association\Boards\Board::class)->make()
 * factory(Francken\Association\Boards\Board::class)->make(['board_year' => 2020])
 * factory(Francken\Association\Boards\Board::class)->make(['installed_at' => '2020-01-01'])
 */
$factory->define(Board::class, function (Faker $faker, array $board) {
    $installedAt = $board['installed_at']
        ? DateTimeImmutable::createFromFormat('Y-m-d', $board['installed_at'])
        : $faker->dateTime('2030-01-01');

    $boardYear = (int)$installedAt->format('Y');
    $endBoardYear = $boardYear + 1;

    return [
        'name' => $faker->name,
        'photo_position' => $faker->word,
        'installed_at' => DateTimeImmutable::createFromFormat('!Y-m-d', "{$boardYear}-06-06"),
        'demissioned_at' => DateTimeImmutable::createFromFormat('!Y-m-d', "{$endBoardYear}-06-06"),
        'decharged_at' => DateTimeImmutable::createFromFormat('!Y-m-d', "{$endBoardYear}-06-06"),
        'board_year_slug' => "{$boardYear}-{$endBoardYear}",
        'photo_media_id' => null,
    ];
});
