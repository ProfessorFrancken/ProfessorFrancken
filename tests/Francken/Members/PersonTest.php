<?php

namespace Tests\Francken\Domain\Members;

use Francken\Domain\Members\Person;
use Francken\Domain\Members\ContactInfo;
use Francken\Domain\Members\FullName;
use Francken\Domain\Members\Address;
use Francken\Domain\Members\Gender;
use Francken\Domain\Members\Email;
use DateTimeImmutable;

class PersonTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function a_person_is_described_by_its_personal_information_and_contact_information()
    {
        $contact = ContactInfo::describe(
            new Email('markredeman@gmail.com'),
            new Address(
                'Groningen',
                '9742GS',
                'Plutolaan 11'
            )
        );

        $fullName = new FullName(
            'Mark',
            null,
            'Redeman'
        );

        $person = Person::describe(
            $fullName,
            Gender::fromString('male'),
            new DateTimeImmutable('1993-04-26'),
            $contact
        );

        $this->assertInstanceOf(Person::class, $person);
        $this->assertEquals('Mark', $person->firstname());
        $this->assertEquals('Redeman', $person->surname());
        $this->assertEquals(Person::MALE, $person->gender());
    }
}
