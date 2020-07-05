<?php

declare(strict_types=1);

namespace Francken\Tests\Association\Members;

use PHPUnit\Framework\TestCase;
use Francken\Association\Members\Email;
use InvalidArgumentException;

class EmailTest extends TestCase
{
    /** @test */
    public function it_stores_an_email() : void
    {
        $email = new Email('markredeman@gmail.com');

        $this->assertEquals('markredeman@gmail.com', $email->toString());
    }

    /** @test */
    public function it_accepts_an_email_with_gmail_aliases() : void
    {
        $email = new Email('markredeman+123@gmail.com');

        $this->assertEquals('markredeman+123@gmail.com', $email->toString());
    }

    /**
     * @test
     */
    public function it_does_not_store_invalid_emails() : void
    {
        $this->expectException(InvalidArgumentException::class);
        new Email('markredeman.com');
    }
}
