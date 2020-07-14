<?php

declare(strict_types=1);

namespace Francken\Tests\Association\Members;

use Francken\Association\Members\Address;
use Francken\Association\Members\ContactDetails;
use Francken\Shared\Email;
use PHPUnit\Framework\TestCase;

class ContactDetailsTest extends TestCase
{
    /** @test */
    public function a_contact_needs_an_address_and_an_email() : void
    {
        $contact = new ContactDetails(
            new Email('markredeman@gmail.com'),
            new Address(
                'Groningen',
                '9742GS',
                'Plutolaan',
                '11'
            ),
            null
        );

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
    public function a_contact_can_be_given_a_phone_number() : void
    {
        $contact = new ContactDetails(
            new Email('markredeman@gmail.com'),
            new Address(
                'Groningen',
                '9742GS',
                'Plutolaan',
                '11'
            ),
            '+31-655-5754-22'
        );
        $this->assertEquals(
            '+31-655-5754-22',
            $contact->phoneNumber()
        );
    }

    /** @test */
    public function a_contact_can_be_given_without_an_address() : void
    {
        $contact = new ContactDetails(
            new Email('markredeman@gmail.com'),
            null,
            '+31-655-5754-22'
        );
        $this->assertNull($contact->address());
    }
}
