<?php

declare(strict_types=1);

namespace Tests\Francken\Domain\Members;

use DateTimeImmutable;
use Francken\Domain\Members\Study;
use Francken\Domain\Members\StudyDetails;
use Francken\Tests\SetupReconstitution;

class StudyDetailsTest extends \PHPUnit\Framework\TestCase
{
    use SetupReconstitution;

    /** @test */
    public function it_is_constructed_with_study_details() : void
    {
        $studyDetails = new StudyDetails(
            's2218356',
            new Study(
                'Msc Applied Mathematics',
                new DateTimeImmutable('01-08-2011'),
                new DateTimeImmutable('01-08-2014')
            )
        );

        $this->assertEquals([
            new Study(
                'Msc Applied Mathematics',
                new DateTimeImmutable('01-08-2011'),
                new DateTimeImmutable('01-08-2014')
            )
        ], $studyDetails->studies());

        $this->assertEquals('s2218356', $studyDetails->studentNumber());
    }

    /** @test */
    public function it_is_serializable() : void
    {
        $studyDetails = new StudyDetails(
            's2218356',
            new Study(
                'Msc Applied Mathematics',
                new DateTimeImmutable('01-08-2011'),
                new DateTimeImmutable('01-08-2014')
            )
        );

        $this->assertEquals(
            $studyDetails,
            StudyDetails::deserialize($studyDetails->serialize())
        );
    }
}
