<?php

declare(strict_types=1);

namespace Francken\Features;

use Auth;
use DB;
use Francken\Application\Members\Registration\RequestStatus;
use Francken\Application\Members\Registration\RequestStatusRepository;
use Francken\Domain\Members\Address;
use Francken\Domain\Members\Email;
use Francken\Domain\Members\FullName;
use Francken\Domain\Members\Registration\Events\RegistrationRequestSubmitted;
use Francken\Domain\Members\Registration\RegistrationRequestId;
use Francken\Domain\Members\Registration\RegistrationRequestRepository;
use Francken\Domain\Members\StudyDetails;
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
            ->type('Groningen', 'city')
            ->type('Nijenborgh 9', 'address')
            ->type('9742GS', 'zip-code')

            // Study details
            ->type('s2218356', 'student-number')
            ->type('Msc Applied Mathematics', 'study-name[0]')
            ->type('2011-04', 'study-starting-date[0]')

            ->press('Submit request');

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
}
