<?php

declare(strict_types=1);

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use Francken\Association\Activities\Activity;
use Francken\Association\Activities\Comment;
use Francken\Association\LegacyMember;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'activity_id' => factory(Activity::class),
        'member_id' => factory(LegacyMember::class),
        'content' => $faker->text,
    ];
});
