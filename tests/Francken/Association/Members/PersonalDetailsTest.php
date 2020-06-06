<?php

declare(strict_types=1);

namespace Tests\Francken\Association\Members;

use Francken\Association\Members\Birthdate;
use Francken\Association\Members\Fullname;
use Francken\Association\Members\Gender;
use Francken\Association\Members\PersonalDetails;
use PHPUnit\Framework\TestCase;

class PersonalDetailsTest extends TestCase
{
    /** @test */
    public function it_can_be_constructed() : void
    {
        $details = new PersonalDetails(
            Fullname::fromFirstnameAndSurname(
                'Mark', 'Redeman'
            ),
            'S.R.',
            Gender::male(),
            Birthdate::fromString('1993-04-26'),
            'Netherlands',
            true
        );

        $this->assertEquals(
            Fullname::fromFirstnameAndSurname(
                'Mark', 'Redeman'
            ),
            $details->fullName()
        );
        $this->assertEquals('S.R.', $details->initials());
        $this->assertEquals(Gender::male(), $details->gender());
        $this->assertEquals(Birthdate::fromString('1993-04-26'), $details->birthdate());
        $this->assertEquals('Netherlands', $details->nationality());
        $this->assertTrue($details->hasDutchDiploma());
    }
}
