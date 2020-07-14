<?php

declare(strict_types=1);

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use Francken\Extern\Partner;
use Francken\Extern\SponsorOptions\CompanyProfile;

$factory->define(CompanyProfile::class, function (Faker $faker) {
    return [
        'partner_id' => factory(Partner::class),
        'display_name' => $faker->word,
        'source_content' => $faker->text,
        'compiled_content' => $faker->text,
        'is_enabled' => $faker->boolean,
    ];
});
