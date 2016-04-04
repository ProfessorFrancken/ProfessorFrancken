<?php

namespace Tests\Francken\Members\Registration\Events;

use Tests\SetupReconstitution;
use Francken\Members\Registration\RegistrationRequestId;
use Francken\Members\Registration\Events\RegistrationRequestSubmitted;
use Francken\Members\Person;
use Francken\Members\ContactInfo;
use Francken\Members\Email;
use Francken\Members\Address;
use DateTimeImmutable;

class ActivityCancelledTest extends \PHPUnit_Framework_TestCase
{
    use SetupReconstitution;

    /** @test */
    public function it_is_insttantiable()
    {
        $id = RegistrationRequestId::generate();
        $person = Person::describe(
            'Mark',
            '',
            'Redeman', // surname
            Person::MALE,
            new DateTimeImmutable('1993-04-26'),
            ContactInfo::describe(
                new Email('markredeman@gmail.com'),
                new Address(
                    'Groningen',
                    '9742GS',
                    'Plutolaan',
                    '11'
                )
            )
        );

        $event = new RegistrationRequestSubmitted(
            $id,
            $person,
            's2218356',
            'Msc Applied Mathematics'
        );

        $this->assertEquals($id, $event->registrationRequestId());
        $this->assertEquals($person, $event->requestee());
        $this->assertEquals('s2218356', $event->studentNumber());
        $this->assertEquals('Msc Applied Mathematics', $event->study());
    }

    /** @test */
    public function it_is_serializable()
    {
        $id = RegistrationRequestId::generate();
        $person = Person::describe(
            'Mark',
            '',
            'Redeman', // surname
            Person::MALE,
            new DateTimeImmutable('1993-04-26'),
            ContactInfo::describe(
                new Email('markredeman@gmail.com'),
                new Address(
                    'Groningen',
                    '9742GS',
                    'Plutolaan',
                    '11'
                )
            )
        );

        $event = new RegistrationRequestSubmitted(
            $id,
            $person,
            's2218356',
            'Msc Applied Mathematics'
        );

        $this->assertEquals(
            $event,
            RegistrationRequestSubmitted::deserialize($event->serialize())
        );
    }
}
