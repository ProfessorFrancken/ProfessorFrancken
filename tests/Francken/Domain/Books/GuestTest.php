<?php

namespace Tests\Francken\Posts;

use Francken\Domain\Books\Guest;
use Francken\Domain\Members\Email;


class GuestTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function a_guest_is_instantiated_with_a_name_and_email()
    {
        $email = new Email("hoi@gmail.com");
        $name = "firstname lastname";
        $guest = new Guest($name, $email);

        $this->assertInstanceOf(Guest::class, $guest);
        $this->assertEquals($email, $guest->email());
        $this->assertEquals($name, $guest->name());
    }

    /** @test */
    public function it_is_serializable()
    {
        $this->markTestSkipped('Should i be serializable?');
        $email = new Email("hoi@gmail.com");
        $name = "myname lastname";
        $guest = new Guest($name, $email);

        $this->assertEquals($guest, Guest::deserialize($guest->serialize()));
    }
}
