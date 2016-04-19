<?php

namespace Tests\Francken\Domain\Members;

use Francken\Domain\Members\FullName;

class FullNameTest extends \PHPUnit_Framework_TestCase
{
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
    }
}
