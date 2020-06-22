<?php

declare(strict_types=1);

namespace Tests\Francken\Domain\Members;

use Francken\Domain\Members\Address;
use Francken\Domain\Members\ContactInfo;
use Francken\Shared\Email;
use Francken\Tests\SetupReconstitution;

class ContactInfoTest extends \PHPUnit\Framework\TestCase
{
    use SetupReconstitution;

    /** @test */
    public function a_contact_needs_an_address_and_an_email() : void
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
    public function it_is_serializable() : void
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
