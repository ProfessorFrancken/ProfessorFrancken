<?php

declare(strict_types=1);

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use Francken\Extern\Partner;
use Francken\Extern\PartnerStatus;
use Francken\Extern\Sector;
use Illuminate\Support\Str;

$factory->define(Partner::class, function (Faker $faker) {
    return [
        'sector_id' => factory(Sector::class),
        'name' => $faker->name,
        'slug' => fn (array $partner) => Str::slug($partner['name']),
        'status' => $faker->randomElement([
            PartnerStatus::PRIMARY_PARTNER,
            PartnerStatus::SECONDARY_PARTNER,
            PartnerStatus::ACTIVE_PARTNER,
            PartnerStatus::POTENTIAL_PARTNER,
            PartnerStatus::PAST_PARTNER,
            PartnerStatus::OTHER_PARTNER,
        ]),
        'homepage_url' => $faker->word,
        'referral_url' => $faker->word,
        'logo_media_id' => null, //factory(Plank\Mediable\Media::class),
    ];
});
