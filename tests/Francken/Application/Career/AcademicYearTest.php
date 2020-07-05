<?php

declare(strict_types=1);

namespace Francken\Tests\Application\Career;

use DateTimeImmutable;
use Francken\Shared\AcademicYear;
use PHPUnit\Framework\TestCase as TestCase;

class AcademicYearTest extends TestCase
{
    /** @test */
    public function it_can_be_constructed_using_only_two_years() : void
    {
        $year = AcademicYear::fromString('2016-2017');

        $this->assertEquals('2016 - 2017', $year->toString());
    }

    /** @test */
    public function it_returns_the_next_academic_year_after_the_current_one() : void
    {
        $year = AcademicYear::fromString('2016-2017');

        $this->assertEquals('2017 - 2018', $year->nextYear()->toString());
    }

    /** @test */
    public function it_returns_the_previous_academic_year_before_the_current_one() : void
    {
        $year = AcademicYear::fromString('2016-2017');

        $this->assertEquals('2015 - 2016', $year->previousYear()->toString());
    }

    /** @test */
    public function it_can_check_whether_a_date_is_in_an_academic_date() : void
    {
        $year = AcademicYear::fromString('2016-2017');

        // All dates ranging from August first 2016 unitl August first 2017 are valid
        $data = [
            '2016-08-01' => true,
            '2016-09-01' => true,
            '2016-10-01' => true,
            '2016-11-01' => true,
            '2016-12-01' => true,
            '2017-01-01' => true,
            '2017-02-01' => true,
            '2017-03-01' => true,
            '2017-04-01' => true,
            '2017-05-01' => true,
            '2017-06-01' => true,
            '2017-07-01' => false,

            // Check dates outside its range
            '2015-08-01' => false,
            '2015-09-01' => false,
            '2015-10-01' => false,
            '2015-11-01' => false,
            '2015-12-01' => false,
            '2016-01-01' => false,
            '2016-02-01' => false,
            '2016-03-01' => false,
            '2016-04-01' => false,
            '2016-05-01' => false,
            '2016-06-01' => false,
            '2016-07-01' => false,

            '2017-08-01' => false,
            '2017-09-01' => false,
            '2017-10-01' => false,
            '2017-11-01' => false,
            '2017-12-01' => false,
            '2018-01-01' => false,
            '2018-02-01' => false,
            '2018-03-01' => false,
            '2018-04-01' => false,
            '2018-05-01' => false,
            '2018-06-01' => false,
            '2018-07-01' => false,
        ];

        foreach ($data as $date => $contained) {
            $this->assertEquals(
                $contained,
                $year->contains(new DateTimeImmutable($date)),
                sprintf(
                    '%s is not contained in the academic year of %s',
                    $date,
                    $year->toString()
                )
            );
        }
    }

    /** @test */
    public function it_can_return_the_academic_year_associated_to_a_date() : void
    {
        $year = AcademicYear::fromDate(new DateTimeImmutable('17-07-2017'));

        $this->assertEquals('2017 - 2018', $year->toString());
    }
}
