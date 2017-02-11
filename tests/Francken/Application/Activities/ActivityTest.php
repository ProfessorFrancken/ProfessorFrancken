<?php

declare(strict_types=1);

namespace Francken\Tests\Application\Activities;

use DateTimeImmutable;
use Francken\Tests\Application\ReadModelTestCase;
use Francken\Application\Activities\Activity;
use Francken\Domain\Activities\ActivityId;
use Francken\Domain\Activities\Schedule;
use Francken\Domain\Activities\Location;


class ActivityTest extends ReadModelTestCase
{
    /** @test */
    public function an_activity_has_a_name_category_schedule_and_location()
    {
        $id = ActivityId::generate();
        $schedule = Schedule::withStartTime(new DateTimeImmutable());

        $activity = new Activity(
            $id,
            "Crash and Compile",
            false,
            'social',
            $schedule,
            Location::fromNameAndAddress('Francken Kamer'),
            []
        );

        $this->assertEquals($activity->getId(), (string)$id);
        $this->assertEquals($activity->activityId(), $id);
        $this->assertEquals($activity->published(), false);
        $this->assertEquals($activity->category(), 'social');
        $this->assertEquals($activity->schedule(), $schedule);
        $this->assertEquals($activity->location(), Location::fromNameAndAddress('Francken Kamer'));
        $this->assertEquals($activity->participants(), []);
    }

    protected function createInstance() : Activity
    {
        $id = ActivityId::generate();

        return new Activity(
            $id,
            "Crash and Compile",
            false,
            'social',
            Schedule::withStartTime(new DateTimeImmutable()),
            Location::fromNameAndAddress('Francken Kamer'),
            []
        );
    }
}
