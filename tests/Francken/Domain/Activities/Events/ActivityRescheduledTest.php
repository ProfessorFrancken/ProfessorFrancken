<?php

declare(strict_types=1);

namespace Tests\Francken\Activities\Events;

use Francken\Tests\SetupReconstitution;
use Francken\Domain\Activities\ActivityId;
use Francken\Domain\Activities\Schedule;
use Francken\Domain\Activities\Events\ActivityRescheduled;
use DateTimeImmutable;

class ActivityRescheduledTest extends \PHPUnit_Framework_TestCase
{
    use SetupReconstitution;

    /**
     * @test
     */
    public function it_happend_to_an_activity()
    {
        $id = ActivityId::generate();

        $event = new ActivityRescheduled(
            $id,
            Schedule::forPeriod(
                new DateTimeImmutable('2015-10-03 14:30'),
                new DateTimeImmutable('2015-10-03 15:30')
            )
        );

        $this->assertEquals($id, $event->activityId());
        $this->assertEquals(
            Schedule::forPeriod(
                new DateTimeImmutable('2015-10-03 14:30'),
                new DateTimeImmutable('2015-10-03 15:30')
            ),
            $event->schedule()
        );
    }

    /**
     * @test
     */
    public function it_is_serializable()
    {
        $id = ActivityId::generate();
        $event = new ActivityRescheduled(
            $id,
            Schedule::forPeriod(
                new DateTimeImmutable('2015-10-03 14:30'),
                new DateTimeImmutable('2015-10-03 15:30')
            )
        );

        $this->assertEquals(
            $event,
            ActivityRescheduled::deserialize($event->serialize())
        );
    }
}
