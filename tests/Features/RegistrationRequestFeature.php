<?php

declare(strict_types=1);

namespace Francken\Features;

use Francken\Application\Members\Registration\RequestStatus;
use Francken\Application\Members\Registration\RequestStatusRepository;
use Francken\Domain\Members\Registration\Events\RegistrationRequestSubmitted;
use Francken\Domain\Members\Registration\RegistrationRequestId;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

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

    /** @test */
    function listing_all_open_registration_requests()
    {
        $requests = $this->app->make(RequestStatusRepository::class);
        $requests->save(
            new RequestStatus(
                new RegistrationRequestId('fffbfb4c-378b-4c76-a0e6-629f3e4e1e9a'),
                'Mark Redeman',
                true,
                true,
                true,
                true,
                \DateTimeImmutable::createFromFormat(
                    \DateTime::ISO8601,
                    '2016-11-18T15:52:01+0000'
                )
            )
        );

        $this->visit('/admin/registration-requests')
            ->see('Mark Redeman');
    }

    /** @test */
    function listing_details_of_a_registration_request()
    {
        $requests = $this->app->make(RequestStatusRepository::class);
        $requests->save(
            new RequestStatus(
                new RegistrationRequestId('fffbfb4c-378b-4c76-a0e6-629f3e4e1e9a'),
                'Mark Redeman',
                true,
                true,
                true,
                true,
                \DateTimeImmutable::createFromFormat(
                    \DateTime::ISO8601,
                    '2016-11-18T15:52:01+0000'
                )
            )
        );

        $this->visit('admin/registration-requests/fffbfb4c-378b-4c76-a0e6-629f3e4e1e9a')
            ->see('Mark Redeman');
    }
}
