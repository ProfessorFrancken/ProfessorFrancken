<?php

declare(strict_types=1);

namespace Tests\Francken\Activities\Events;

use DateTimeImmutable;
use Francken\Domain\Activities\ActivityId;
use Francken\Domain\Activities\Events\ActivityRescheduled;
use Francken\Domain\Activities\Schedule;
use Francken\Tests\Domain\EventTestCase as Testcase;

class ActivityRescheduledTest extends TestCase
{
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

    protected function createInstance()
    {
        return new ActivityRescheduled(
            ActivityId::generate(),
            Schedule::forPeriod(
                new DateTimeImmutable('2015-10-03 14:30'),
                new DateTimeImmutable('2015-10-03 15:30')
            )
        );
    }
}
