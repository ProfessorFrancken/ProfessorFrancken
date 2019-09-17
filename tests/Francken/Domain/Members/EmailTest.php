<?php

declare(strict_types=1);

namespace Tests\Francken\Domain\Members;

use Francken\Domain\Members\Email;
use InvalidArgumentException;

class EmailTest extends \PHPUnit\Framework\TestCase
{
    /** @test */
    public function it_stores_an_email() : void
    {
        $email = new Email('markredeman@gmail.com');

        $this->assertEquals('markredeman@gmail.com', (string) $email);
    }

    /** @test */
    public function it_accepts_an_email_with_gmail_aliases() : void
    {
        $email = new Email('markredeman+123@gmail.com');

        $this->assertEquals('markredeman+123@gmail.com', (string) $email);
    }

    /**
     * @test
     */
    public function it_does_not_store_invalid_emails() : void
    {
        $this->expectException(InvalidArgumentException::class);
        $email = new Email('markredeman.com');
    }
}
