<?php

declare(strict_types=1);

namespace Tests\Francken\Association\Members;

use Francken\Association\Members\Gender;
use PHPUnit\Framework\TestCase;

class GenderTest extends TestCase
{
    /** @test */
    public function it_represents_female_gender() : void
    {
        $gender = Gender::female();
        $this->assertSame(GENDER::FEMALE, $gender->toString());
    }

    /** @test */
    public function it_represents_male_gender() : void
    {
        $gender = Gender::male();
        $this->assertSame(GENDER::MALE, $gender->toString());
    }
    
    /** @test */
    public function it_allows_any_other_gender() : void
    {
        $gender = Gender::other('foo');
        $this->assertSame('foo', $gender->toString());
    }

    /** @test */
    public function it_allows_constructing_a_gender_via_standardized_from_string() : void
    {
        $gender = Gender::fromString('foo');
        $this->assertSame('foo', $gender->toString());
    }
}
