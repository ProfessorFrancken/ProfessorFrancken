<?php

declare(strict_types=1);

use Francken\Domain\Members\Address;
use Francken\Domain\Members\StudyDetails;
use Francken\Domain\Members\ContactInfo;
use Francken\Domain\Members\Email;
use Francken\Domain\Members\FullName;
use Francken\Domain\Members\Gender;
use Francken\Domain\Members\PaymentInfo;
use Francken\Domain\Members\Registration\RegistrationRequest;
use Francken\Domain\Members\Registration\RegistrationRequestId;
use Francken\Domain\Members\Registration\RegistrationRequestRepository as Repository;
use Illuminate\Database\Seeder;

final class RegistrationRequestsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $repo = App::make(Repository::class);
        $faker = App::make(Faker\Generator::class);

        $genders =['male', 'female'];

        for ($i = 0; $i < 10; $i++) {
            $id = RegistrationRequestId::generate();

            $gender = $faker->randomElement($genders);

            $request = RegistrationRequest::submit(
                $id,
                new FullName(
                    $faker->firstName($gender),
                    '',
                    $faker->lastName
                ),
                Gender::fromString($gender),
                DateTimeImmutable::createFromMutable($faker->dateTimeInInterval('- 30 years', '-16 years')),
                ContactInfo::describe(
                    new Email($faker->safeEmail),
                    new Address(
                        $faker->city,
                        $faker->postCode,
                        $faker->streetAddress
                    )
                ),
                new StudyDetails(
                    's2218356',
                    'Msc Applied Mathematics',
                    new DateTimeImmutable('2011-09-01')
                ),
                new PaymentInfo(true, $faker->boolean)
                // note: could add an additional "comment" section where a foreigner could tell the board that he/she lives outside of the Netherlands
            );

            $repo->save($request);
        }
    }
}
