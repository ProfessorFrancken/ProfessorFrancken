<?php

namespace Tests\Francken\Domain\Members;

use Francken\Domain\Members\Gender;
use Tests\SetupReconstitution;

class GenderTest extends \PHPUnit_Framework_TestCase
{
    use SetupReconstitution;

    /** @test */
    public function it_can_be_constructed_from_a_string()
    {
        $gender = Gender::fromString('male');

        $this->assertInstanceOf(Gender::class, $gender);
        $this->assertEquals(Gender::MALE, (string) $gender);
    }

    /** @test */
    public function it_accepts_a_female_gender()
    {
        $gender = Gender::fromString('female');

        $this->assertEquals(Gender::FEMALE, (string) $gender);
    }

    /** @test */
    public function it_accepts_a_male_gender()
    {
        $gender = Gender::fromString('male');

        $this->assertEquals(Gender::MALE, (string) $gender);
    }

    /** @test */
    public function it_does_not_accept_an_invalid_gender()
    {
        $this->expectException(\InvalidArgumentException::class);
        Gender::fromString('foo');
    }

    /** @test */
    public function it_is_serializable()
    {
        $gender = Gender::fromString('male');

        $this->assertEquals(
            $gender,
            Gender::deserialize($gender->serialize())
        );
    }
}
