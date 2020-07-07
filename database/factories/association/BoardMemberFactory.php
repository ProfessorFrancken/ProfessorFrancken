<?php

declare(strict_types=1);

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use Francken\Association\Boards\Board;
use Francken\Association\Boards\BoardMember;
use Francken\Association\Boards\BoardMemberStatus;
use Francken\Association\LegacyMember;

$factory->define(BoardMember::class, function (Faker $faker, array $member) {
    $board = Board::find($member['board_id'] ?? null) ?? factory(Board::class)->create();

    $now = new DateTimeImmutable();
    $installedAt = $board->installed_at;
    $demissionedAt = $board->demissioned_at;
    $dechargedAt = $board->decharged_at;

    return [
        'board_id' => $board->id,
        'member_id' => factory(LegacyMember::class),
        'title' => $faker->word,
        'name' => $faker->name,
        'board_member_status' => BoardMemberStatus::fromDates(
            $now,
            $installedAt,
            $demissionedAt,
            $dechargedAt
        ),
        'installed_at' => $installedAt,
        'demissioned_at' => $demissionedAt,
        'decharged_at' => $dechargedAt,
        'photo_media_id' => null, //factory(Plank\Mediable\Media::class),
    ];
});
