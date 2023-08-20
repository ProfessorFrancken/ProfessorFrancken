<?php

declare(strict_types=1);

namespace Francken\Features;

use Illuminate\Validation\ValidationException;

class RegistrationRequestFeature extends TestCase
{
    /**
     * @test
     */
    public function a_registration_request_can_be_submitted() : void
    {
        $this->withoutExceptionHandling();
        $this->visit('/register')
             ->seePageIs('/register')

            ->see('Register to be a Francken member')
            // Personal details
            ->type('Mark', 'firstname')
            ->type('Redeman', 'surname')
            ->type('Netherlans', 'nationality')
            ->type('1993-04-26', 'birthdate')
            ->select('male', 'gender')

            ->type('Nederlands', 'nationality')

            // Contact Details
            ->type('markredeman@gmail.com', 'email')
            ->type('Groningen', 'city')
            ->type('Nijenborgh 9', 'address')
            ->type('9742GS', 'postal_code')
            ->type('Netherlands', 'country')

            // Study details
            ->type('s2218356', 'student_number')
            ->type('Msc Applied Mathematics', 'study_name[0]')
            ->type('2011-04', 'study_starting_date[0]')
                 // ->type('hoi', 'iban')

             ->type('NL91 ABNA 0417 1643 00', 'iban')
            ->press('Register');

        $this->assertResponseOk()
            ->see('Hi Mark Redeman, thank you for registering!');
    }

    /**
     * @test
     */
    public function a_registration_request_must_have_valid_data() : void
    {
        $this->withoutExceptionHandling();
        $this->expectException(ValidationException::class);
        $this->visit('/register')
            ->press('Register');
    }
    /**
     * @test
     */
    public function it_gives_validation_errors() : void
    {
        $this->withoutExceptionHandling();
        try {
            $this->visit('/register')
                ->type('Netherlands', 'country')
                ->press('Register');
            // ->seePageIs('/register')
            // ->assertSessionHasErrors()
            // ->dump()
            //  ->assertResponseStatus(402)
            //  ->assertViewHas('errors')
        } catch (ValidationException $e) {
            $errors = $e->errors();

            $missingFields = [
                'firstname',
                'surname',
                'birthdate',
                'gender',
                'email',
                'city',
                'address',
                'postal_code',
                'study_name.0',
                'study_starting_date.0',
            ];

            foreach ($missingFields as $field) {
                $this->assertArrayHasKey($field, $errors);
            }
        }
    }

    private function submitRegistration() : Registration
    {
        return Registration::submit(
            new PersonalDetails(
                Fullname::fromFirstnameAndSurname('Mark', 'Redeman'),
                'M. S.',
                Gender::MALE(),
                Birthdate::fromString('1993-04-26'),
                'Netherlands',
                true
            ),
            new ContactDetails(
                new Email('markredeman@gmail.com'),
                new Address(
                    'Groningen',
                    '9742 GS',
                    'Nijenborgh 9',
                    'Netherlands'
                ),
                null
            ),
            new StudyDetails('s1111111'),
            new PaymentDetails('NL91 ABNA 0417 1643 00', null, true),
            true,
            ''
        );
    }
}
