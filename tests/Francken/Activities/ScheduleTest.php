<?php

namespace Tests\Francken\Activities;

use Francken\Activities\Schedule;
use DateTimeImmutable;
use InvalidArgumentException;

class ScheduleTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function a_schedule_has_a_start_time()
    {
        $startTime = new DateTimeImmutable('2015-03-10');
        $schedule = Schedule::withStartTime($startTime);

        $this->assertInstanceOf(Schedule::class, $schedule);
        $this->assertEquals($startTime, $schedule->startTime());
        $this->assertNull($schedule->endTime());
    }

    /** @test */
    public function a_schedule_can_have_an_end_date()
    {
        $startTime = new DateTimeImmutable('2015-03-10 10:00');
        $endTime = new DateTimeImmutable('2015-03-10 11:00');
        $schedule = Schedule::forPeriod($startTime, $endTime);

        $this->assertInstanceOf(Schedule::class, $schedule);
        $this->assertEquals($startTime, $schedule->startTime());
        $this->assertEquals($endTime, $schedule->endTime());
    }

    /**
     * @test
     */
    public function the_end_time_is_after_the_start_time()
    {
        $this->expectException(InvalidArgumentException::class);
        $startTime = new DateTimeImmutable('2015-03-10 10:00');
        $endTime = new DateTimeImmutable('2015-03-10 9:00');
        $schedule = Schedule::forPeriod($startTime, $endTime);
    }

    /**
     * @test
     */
    public function the_end_time_and_the_start_time_cant_be_identical()
    {
        $this->expectException(InvalidArgumentException::class);
        $time = new DateTimeImmutable('2015-03-10 10:00');
        $schedule = Schedule::forPeriod($time, $time);
    }
}
