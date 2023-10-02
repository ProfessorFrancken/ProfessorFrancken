<?php

declare(strict_types=1);

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use Francken\Extern\Partner;
use Francken\Extern\SponsorOptions\FccFooter;

$factory->define(FccFooter::class, function (Faker $faker) {
    return [
        'partner_id' => factory(Partner::class),
        'logo_media_id' => factory(Plank\Mediable\Media::class),
        'is_enabled' => $faker->boolean,
    ];
});
