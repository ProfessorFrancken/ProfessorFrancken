<?php

declare(strict_types=1);

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use Francken\Association\LegacyMember;
use Francken\Auth\Account;

$factory->define(Account::class, function (Faker $faker) {
    return [
        'email' => $faker->safeEmail,
        'password' => bcrypt($faker->password),
        'member_id' => factory(LegacyMember::class),
        'remember_token' => Str::random(10),
    ];
});
