<?php

declare(strict_types=1);

namespace Tests\Francken\Association\Members;

use DateTimeImmutable;
use Francken\Association\Members\Birthdate;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class BirthdateTest extends TestCase
{
    /** @test */
    public function it_can_be_constructed_from_a_string() : void
    {
        $birthdate = Birthdate::fromString('2019-01-01');
        $this->assertSame('2019-01-01', $birthdate->toString());
    }

    /** @test */
    public function it_does_not_allow_invalid_formats_when_constructing_from_a_string() : void
    {
        $this->expectException(InvalidArgumentException::class);

        Birthdate::fromString('01-2019-01');
    }

    /** @test */
    public function it_can_be_constructed_from_a_datetime() : void
    {
        $birthdate = Birthdate::fromDateTime(
            DateTimeImmutable::createFromFormat('Y-m-d', '2019-01-01')
        );
        $this->assertSame('2019-01-01', $birthdate->toString());
    }

    /** @test */
    public function it_has_no_time_information_when_converting_to_datetime() : void
    {
        $birthdate = Birthdate::fromDateTime(
            DateTimeImmutable::createFromFormat('Y-m-d', '2019-01-01')
        );

        $this->assertEquals(
            '2019-01-01T00:00:00', $birthdate->toDateTime()->format('Y-m-d\TH:i:s')
        );
    }

    /** @test */
    public function it_finds_the_age_of_a_person_at_a_given_date() : void
    {
        $birthdate = Birthdate::fromDateTime(
            DateTimeImmutable::createFromFormat('Y-m-d', '1993-01-01')
        );

        $this->assertEquals(
            26,
            $birthdate->ageAt(DateTimeImmutable::createFromFormat('Y-m-d', '2019-01-01'))
        );
    }
}
