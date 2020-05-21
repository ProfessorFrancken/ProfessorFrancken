<?php

declare(strict_types=1);

namespace Tests\Francken\Association\Members;

use Francken\Association\Members\Fullname;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class FullnameTest extends TestCase
{
    /** @test */
    public function it_can_be_constructed_from_a_first_and_surname() : void
    {
        $fullname = Fullname::fromFirstnameAndSurname('Mark', 'Redeman');
        $this->assertSame('Mark Redeman', $fullname->toString());
        $this->assertSame('Mark', $fullname->firstname());
        $this->assertSame('Redeman', $fullname->surname());
    }

    /** @test */
    public function its_firstname_cant_be_empty() : void
    {
        $this->expectException(InvalidArgumentException::class);
        Fullname::fromFirstnameAndSurname('', 'Redeman');
    }

    /** @test */
    public function its_surname_cant_be_empty() : void
    {
        $this->expectException(InvalidArgumentException::class);
        Fullname::fromFirstnameAndSurname('Mark', '');
    }
}
