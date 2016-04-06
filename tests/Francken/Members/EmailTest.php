<?php

namespace Tests\Francken\Members;

use Francken\Members\Email;

class EmailTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_stores_an_email()
    {
        $email = new Email('markredeman@gmail.com');

        $this->assertEquals('markredeman@gmail.com', (string) $email);
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function it_does_not_store_invalid_emails()
    {
        $email = new Email('markredeman.com');
    }
}
