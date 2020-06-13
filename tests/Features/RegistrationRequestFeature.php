<?php

declare(strict_types=1);

namespace Francken\Features;

use Francken\Domain\Members\Address;
use Francken\Domain\Members\Email;
use Francken\Domain\Members\FullName;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RegistrationRequestFeature extends TestCase
{
    use DatabaseMigrations;

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
            ->type('9742GS', 'zip_code')

            // Study details
            ->type('s2218356', 'student_number')
            ->type('Msc Applied Mathematics', 'study_name[0]')
            ->type('2011-04', 'study_starting_date[0]')
                 // ->type('hoi', 'iban')
            ->press('Submit request');

        return;
        dump('hoi');

        $this->seeInDatabase('event_store', [
            'type' => 'Francken.Domain.Members.Registration.Events.RegistrationRequestSubmitted'
        ]);

        $this->seeInDatabase('request_status', [
            'requestee' => 'Mark Redeman'
        ]);

        $rq = \DB::table('request_status')->orderBy('submittedAt', 'desc')->first();

        $store = app(\Broadway\EventStore\EventStore::class);
        $events = $store->load($rq->id);
        $event = array_first($events)->getPayload();

        $this->assertEquals(
            new FullName("Mark", "", "Redeman"), $event->fullname()
        );

        $this->assertEquals(
            new Email("markredeman@gmail.com"), $event->email()
        );

        $this->assertEquals(
            new Address("Groningen", "9742GS", "Nijenborgh 9"), $event->address()
        );

        $this->assertCount(1, $event->studies());
    }

    /**
     * @test
     */
    public function a_registration_request_must_have_valid_data() : void
    {
        $this->withoutExceptionHandling();
        $this->expectException(\Illuminate\Validation\ValidationException::class);
        $this->visit('/register')
            ->press('Submit request');
    }
    /**
     * @test
     */
    public function it_gives_validation_errors() : void
    {
        $this->withoutExceptionHandling();
        return;
        try {
            $this->visit('/register')
            ->press('Submit request');
            // ->seePageIs('/register')
             // ->assertSessionHasErrors()
            // ->dump()
            //  ->assertResponseStatus(402)
            //  ->assertViewHas('errors')
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->errors();

            $missing_fields = [
                'firstname',
                'surname',
                'birthdate',
                'mother_tongue',
                'nationality',
                // 'gender',
                'email',
                'city',
                'address',
                'zip_code',
                'study_name.0',
                'study_starting_date.0',
            ];

            foreach ($missing_fields as $field) {
                $this->assertArrayHasKey($field, $errors);
            }
            dump($errors);
        }
    }

    /**
     * @test
     */
    public function it_keeps_information_after_submitting_an_invalid_form() : void
    {
        // TODO: check that the study information remains
    }
}
