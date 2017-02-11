<?php

declare(strict_types=1);

namespace Tests\Francken\Activities\Events;

use DateTimeImmutable;
use Francken\Domain\Activities\Activity;
use Francken\Domain\Activities\ActivityId;
use Francken\Domain\Activities\Events\ActivityPlanned;
use Francken\Domain\Activities\Location;
use Francken\Domain\Activities\Schedule;
use Francken\Tests\Domain\EventTestCase as Testcase;

class ActivityPlannedTest extends TestCase
{
    /**
     * @test
     */
    public function it_happend_to_an_activity()
    {
        $id = ActivityId::generate();
        $event = new ActivityPlanned(
            $id,
            "Crash & Compile",
            "Programming competition",
            Schedule::withStartTime(new DateTimeImmutable('2015-10-01 14:30')),
            Location::fromNameAndAddress("Francken kamer"),
            Activity::SOCIAL
        );

        $this->assertEquals($id, $event->activityId());
        $this->assertEquals("Crash & Compile", $event->name());
        $this->assertEquals("Programming competition", $event->description());
        $this->assertEquals(new DateTimeImmutable("2015-10-01 14:30"), $event->startTime());
        $this->assertEquals(Location::fromNameAndAddress("Francken kamer"), $event->location());
        $this->assertEquals(Activity::SOCIAL, $event->category());
    }

    /** @test */
    public function the_deserialized_activity_has_the_same_properties()
    {
        $id = ActivityId::generate();
        $event = new ActivityPlanned(
            $id,
            'Crash & Compile',
            'Programming competition',
            Schedule::withStartTime(new DateTimeImmutable('2015-10-01 14:30')),
            Location::fromNameAndAddress('Francken kamer'),
            Activity::SOCIAL
        );

        $event = ActivityPlanned::deserialize($event->serialize());

        $this->assertEquals($id, $event->activityId());
        $this->assertEquals("Crash & Compile", $event->name());
        $this->assertEquals("Programming competition", $event->description());
        $this->assertEquals(new DateTimeImmutable("2015-10-01 14:30"), $event->startTime());
        $this->assertEquals(Location::fromNameAndAddress("Francken kamer"), $event->location());
        $this->assertEquals(Activity::SOCIAL, $event->category());
    }

    protected function createInstance()
    {
        return new ActivityPlanned(
            ActivityId::generate(),
            'Crash & Compile',
            'Programming competition',
            Schedule::withStartTime(new DateTimeImmutable('2015-10-01 14:30')),
            Location::fromNameAndAddress('Francken kamer'),
            Activity::SOCIAL
        );
    }
}
