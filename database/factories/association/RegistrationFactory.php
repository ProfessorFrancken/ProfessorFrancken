<?php

declare(strict_types=1);

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use Francken\Association\Members\Gender;
use Francken\Association\Members\Registration\Registration;

$factory->define(Registration::class, function (Faker $faker) {
    return [
        'firstname' => $faker->firstName,
        'surname' => $faker->lastName,
        'initials' => '',
        'gender' => $faker->randomElement([Gender::MALE, Gender::FEMALE]),
        'birthdate' => $faker->dateTime,
        'has_dutch_diploma' => $faker->boolean,
        'nationality' => 'Netherlands',
        'email' => $faker->safeEmail,
        'city' => $faker->city,
        'address' => $faker->address,
        'postal_code' => $faker->postcode,
        'country' => $faker->country,
        'phone_number' => $faker->phoneNumber,
        'student_number' => '',
        'studies' => '',
        'iban' => $faker->iban(),
        'bic' => null,
        'deduct_additional_costs' => $faker->boolean,
        'comments' => $faker->paragraph,
        'wants_to_join_a_committee' => $faker->boolean,

        'email_verified_at' => $faker->datetime,
        'registration_accepted_at' => $faker->datetime,
        'registration_form_signed_at' => $faker->datetime,
        'member_id' => null,
    ];
});
