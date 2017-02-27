<?php

declare(strict_types=1);

namespace Francken\Tests\Domain\Members;

use Francken\Domain\Members\FullName;
use Francken\Tests\SetupReconstitution;

class FullNameTest extends \PHPUnit_Framework_TestCase
{
    use SetupReconstitution;

    /** @test */
    public function a_name_consists_of_a_firstname_and_a_surname()
    {
        $fullName = new FullName(
            'Mark',
            null,
            'Redeman'
        );

        $this->assertEquals('Mark', $fullName->firstName());
        $this->assertEquals('Redeman', $fullName->surname());
        $this->assertEquals('Mark Redeman', $fullName->fullName());
    }

    /** @test */
    public function an_optional_middlename_can_be_given()
    {
        $fullName = new FullName(
            'Mark',
            'Sietse',
            'Redeman'
        );

        $this->assertEquals('Sietse', $fullName->middlename());
        $this->assertEquals('Mark Sietse Redeman', $fullName->fullName());
    }

    /** @test */
    public function it_is_serializable()
    {
        $fullName = new FullName(
            'Mark',
            'Sietse',
            'Redeman'
        );

        $this->assertEquals(
            $fullName,
            FullName::deserialize($fullName->serialize())
        );
    }
}
