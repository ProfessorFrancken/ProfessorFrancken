<?php

declare(strict_types=1);

namespace Tests\Francken\Domain\Members\Registration\Events;

use DateTimeImmutable;
use Francken\Domain\Members\Address;
use Francken\Domain\Members\ContactInfo;
use Francken\Domain\Members\Email;
use Francken\Domain\Members\FullName;
use Francken\Domain\Members\Gender;
use Francken\Domain\Members\Registration\Events\RegistrationRequestSubmitted;
use Francken\Domain\Members\Registration\RegistrationRequestId;
use Francken\Domain\Members\Study;
use Francken\Domain\Members\StudyDetails;
use Francken\Tests\Domain\EventTestCase as Testcase;

class RegistrationRequestSubmittedTest extends TestCase
{
    /** @test */
    public function it_is_insttantiable()
    {
        $id = RegistrationRequestId::generate();
        $event = $this->registrationRequestSubmitted($id);
        $this->assertEquals($id, $event->registrationRequestId());
        $this->assertEquals('s2218356', $event->studentNumber());
        $this->assertEquals(
            [
                new Study(
                    'Msc Applied Mathematics',
                    new DateTimeImmutable('2011-09-01')
                )
            ],
            $event->studies()
        );

        $this->assertEquals(new FullName(
            'Mark',
            '',
            'Redeman'
        ), $event->fullName());


        $this->assertEquals(
            new Address('Groningen', '9742GS', 'Plutolaan 11'),
            $event->address()
        );

        $this->assertEquals(
            new Email('markredeman@gmail.com'),
            $event->email()
        );
    }

    /** @test */
    public function it_is_serializable()
    {
        $id = RegistrationRequestId::generate();
        $event = $this->registrationRequestSubmitted($id);

        $this->assertEquals(
            $event,
            RegistrationRequestSubmitted::deserialize(
                $event->serialize()
            )
        );
    }

    private function registrationRequestSubmitted(RegistrationRequestId $id) : RegistrationRequestSubmitted
    {
        $fullName = new FullName(
            'Mark',
            '',
            'Redeman'
        );

        return new RegistrationRequestSubmitted(
            $id,
            $fullName,
            Gender::fromString('male'),
            new DateTimeImmutable('1993-04-26'),
            ContactInfo::describe(
                new Email('markredeman@gmail.com'),
                new Address(
                    'Groningen',
                    '9742GS',
                    'Plutolaan 11'
                )
            ),
            new StudyDetails(
                's2218356',
                new Study(
                    'Msc Applied Mathematics',
                    new DateTimeImmutable('2011-09-01')
                )
            )
        );
    }

    protected function createInstance()
    {
        return $this->registrationRequestSubmitted(RegistrationRequestId::generate());
    }
}
