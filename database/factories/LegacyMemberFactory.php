<?php

declare(strict_types=1);

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(Francken\Association\LegacyMember::class, function (Faker $faker) {
    return [
        'geslacht' => $faker->randomElement([
            'M',
            'V',
            'Other'
        ]),
        'titel' => $faker->title,
        'initialen' => $faker->word,
        'voornaam' => $faker->word,
        'tussenvoegsel' => $faker->word,
        'achternaam' => $faker->word,
        'geboortedatum' => $faker->date(),
        'foto' => $faker->word,
        'nederlands' => $faker->boolean,
        'adres' => $faker->address,
        'postcode' => $faker->postcode,
        'plaats' => $faker->city,
        'land' => $faker->country,
        'is_nederland' => $faker->boolean,
        'emailadres' => $faker->safeEmail,
        'telefoonnummer_thuis' => $faker->word,
        'telefoonnummer_werk' => $faker->word,
        'telefoonnummer_mobiel' => $faker->word,
        'rekeningnummer' => $faker->word,
        'plaats_bank' => $faker->word,
        'machtiging' => $faker->boolean,
        'wanbetaler' => $faker->boolean,
        'gratis_lidmaatschap' => $faker->boolean,
        'start_lidmaatschap' => $faker->date(),
        'einde_lidmaatschap' => null, // $faker->date()
        'is_lid' => $faker->boolean,
        'type_lid' => $faker->randomElement([
            'Student RUG', 'Student Hanze', 'Student Anders', 'Promovendus', 'Professor RUG',
            'Werknemer RUG', 'Alumnus TN/N', 'Alumnus niet TN/N', 'Gestopt met studeren',
            'Donateur', 'Anders', 'Student', 'Alumni'
        ]),
        'studentnummer' => $faker->word,
        'studierichting' => $faker->randomElement([
            'Technische Natuurkunde',
            'Natuurkunde',
            '(Technische) Wiskunde',
            '(Technische) Scheikunde',
            'Sterrenkunde',
            'Anders'
        ]),
        'jaar_van_inschrijving' => (int)$faker->year,
        'afstudeerplek' => $faker->word,
        'afgestudeerd' => $faker->boolean,
        'werkgever' => $faker->word,
        'nnvnummer' => $faker->word,
        'streeplijst' => $faker->randomElement([
            'Afschrijven',
            'Contant',
            'Non-actief',
            'Niet',
        ]),
        'mailinglist_email' => $faker->boolean,
        'mailinglist_post' => $faker->boolean,
        'mailinglist_sms' => $faker->boolean,
        'mailinglist_constitutiekaart' => $faker->boolean,
        'mailinglist_franckenvrij' => $faker->boolean,
        'erelid' => $faker->boolean,
        'notities' => $faker->text,
        'deleted_at' => null, // $faker->dateTime(),
    ];
});
