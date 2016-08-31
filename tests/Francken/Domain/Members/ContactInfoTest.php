<?php

declare(strict_types=1);

namespace Tests\Francken\Domain\Members;

use Francken\Domain\Members\ContactInfo;
use Francken\Domain\Members\Email;
use Francken\Domain\Members\Address;
use Francken\Tests\SetupReconstitution;

class ContactInfoTest extends \PHPUnit_Framework_TestCase
{
    use SetupReconstitution;

    /** @test */
    public function a_contact_needs_an_address_and_an_email()
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

        $this->assertInstanceOf(ContactInfo::class, $contact);
        $this->assertEquals(
            new Email('markredeman@gmail.com'),
            $contact->email()
        );

        $this->assertEquals(
            new Address(
                'Groningen',
                '9742GS',
                'Plutolaan',
                '11'
            ),
            $contact->address()
        );
    }

    /** @test */
    public function it_is_serializable()
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

        $this->assertEquals(
            $contact,
            ContactInfo::deserialize($contact->serialize())
        );
    }
}
