<?php

declare(strict_types=1);

namespace Tests\Francken\Activities\Events;

use Francken\Domain\Activities\Activity;
use Francken\Domain\Activities\ActivityId;
use Francken\Domain\Activities\Events\ActivityCategorized;
use Francken\Tests\Domain\EventTestCase as Testcase;

class ActivityCategorizedTest extends TestCase
{
    /**
     * @test
     */
    public function it_happend_to_an_activity()
    {
        $id = ActivityId::generate();
        $event = new ActivityCategorized($id, Activity::SOCIAL);

        $this->assertEquals($id, $event->activityId());
        $this->assertEquals(Activity::SOCIAL, $event->category());
    }

    protected function createInstance()
    {
        return new ActivityCategorized(ActivityId::generate(), Activity::EDUCATION);
    }
}
