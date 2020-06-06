<?php

declare(strict_types=1);

namespace Tests\Francken\Association\Members;

use Francken\Association\Members\Address;
use Francken\Association\Members\ContactDetails;
use Francken\Association\Members\Email;

class ContactDetailsTest extends \PHPUnit\Framework\TestCase
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
            )
        );

        $this->assertInstanceOf(ContactDetails::class, $contact);
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
}
