<?php

namespace Tests\Francken\Domain\Members\Registration\Events;

use Tests\SetupReconstitution;
use Francken\Domain\Members\Registration\RegistrationRequestId;
use Francken\Domain\Members\Registration\Events\RegistrationRequestSubmitted;
use Francken\Domain\Members\ContactInfo;
use Francken\Domain\Members\FullName;
use Francken\Domain\Members\Address;
use Francken\Domain\Members\Gender;
use Francken\Domain\Members\Person;
use Francken\Domain\Members\Email;
use DateTimeImmutable;

class ActivityCancelledTest extends \PHPUnit_Framework_TestCase
{
    use SetupReconstitution;

    /** @test */
    public function it_is_insttantiable()
    {
        $id = RegistrationRequestId::generate();
        $person = Person::describe(
            new FullName(
                'Mark',
                '',
                'Redeman'
            ),
            Gender::fromString('male'),
            new DateTimeImmutable('1993-04-26'),
            ContactInfo::describe(
                new Email('markredeman@gmail.com'),
                new Address(
                    'Groningen',
                    '9742GS',
                    'Plutolaan 11'
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
            new FullName(
                'Mark',
                '',
                'Redeman'
            ),
            Gender::fromString('male'),
            new DateTimeImmutable('1993-04-26'),
            ContactInfo::describe(
                new Email('markredeman@gmail.com'),
                new Address(
                    'Groningen',
                    '9742GS',
                    'Plutolaan 11'
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
