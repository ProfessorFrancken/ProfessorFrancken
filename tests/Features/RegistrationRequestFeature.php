<?php

declare(strict_types=1);

namespace Francken\Features;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Francken\Domain\Members\Registration\Events\RegistrationRequestSubmitted;

class RegistrationRequestFeature extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function a_registration_request_can_be_submitted()
    {
        $this->visit('/register')
            // Personal details
            ->type('Mark', 'firstname')
            ->type('Redeman', 'surname')
            ->type('Dutch', 'mother-tongue')
            ->type('1993-04-26', 'birthdate')
            ->select('male', 'gender')

            // Contact Details
            ->type('markredeman@gmail.com', 'email')
            ->type('groningen', 'city')
            ->type('Nijenborgh 9', 'address')
            ->type('9742GS', 'zip-code')

            // Study details
            ->type('Msc Applied Mathematics', 'study')
            ->type('s2218356', 'student-number')
            ->type('2011-04', 'starting-date-study')

            ->press('Submit request');

        $this->seeInDatabase('event_store', [
            'type' => 'Francken.Domain.Members.Registration.Events.RegistrationRequestSubmitted'
        ]);

        $this->seeInDatabase('request_status', [
            'requestee' => 'Mark Redeman'
        ]);
    }
}
