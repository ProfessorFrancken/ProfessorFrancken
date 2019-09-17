<?php

declare(strict_types=1);

namespace Tests\Francken\Activities\Events;

use Francken\Domain\Activities\ActivityId;
use Francken\Domain\Activities\Events\ActivityPublished;
use Francken\Tests\Domain\EventTestCase as Testcase;

class ActivityPublishedTest extends TestCase
{
    /**
     * @test
     */
    public function it_happend_to_an_activity() : void
    {
        $id = ActivityId::generate();
        $event = new ActivityPublished($id);

        $this->assertEquals($id, $event->activityId());
    }

    protected function createInstance()
    {
        return new ActivityPublished(ActivityId::generate());
    }
}
