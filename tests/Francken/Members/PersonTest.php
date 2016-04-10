<?php

namespace Tests\Francken\Members;

use Francken\Members\Person;
use Francken\Members\ContactInfo;
use Francken\Members\Email;
use Francken\Members\Address;
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
                'Plutolaan',
                '11'
            )
        );

        $person = Person::describe(
            'Mark',
            '',
            'Redeman', // surname
            Person::MALE,
            new DateTimeImmutable('1993-04-26'),
            $contact
        );

        $this->assertInstanceOf(Person::class, $person);
        $this->assertEquals('Mark', $person->firstname());
        $this->assertEquals('Redeman', $person->surname());
        $this->assertEquals(Person::MALE, $person->gender());
    }
}
