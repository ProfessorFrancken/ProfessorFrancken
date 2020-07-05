<?php

declare(strict_types=1);

namespace Francken\Tests\Association\Members;

use PHPUnit\Framework\TestCase;
use DateTimeImmutable;
use Francken\Association\Members\Study;
use Francken\Association\Members\StudyDetails;

class StudyDetailsTest extends TestCase
{
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
}
